<?php

namespace app\modules\shop\controllers;

use common\models\Banner;
use common\models\BlogComments;
use common\models\Brend;
use common\models\Cart;
use common\models\GoodsPhotos;
use common\models\Setup;
use common\models\Video;
use yii\widgets\ActiveForm;
use yii\web\Response;
use common\models\Contacts;
use common\models\GeoCity;
use common\models\Goods;
use common\models\GoodsCategory;
use common\models\ImageSlider;
use common\models\Order;
use common\models\Reqvizit;
use common\models\Review;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\Wishlist;
use common\models\OrderItems;
use yii\web\Session;
use common\models\Compare;
use frontend\models\SignupForm;
use common\models\LoginForm;
use yii\data\Pagination;
use common\models\Blog;
use frontend\helpers\SetupSite;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index',
                            'products',
                            'cart',
                            'blog',
                            'blog-detail',
                            'contact',
                            'detail',
                            'chekout',
                            'wishlist',
                            'comparelist',
                            'add-to-cart',
                            'get-goods-by-category',
                            'add-more-quantity',
                            'remove-more-quantity',
                            'delete-from-cart',
                            'add-to-many-cart',
                            'get-cities',
                            'get-goods-by-brend',
                            'make-order',
                            'order',
                            'add-contact',
                            'add-to-wishlist',
                            'remove-from-wishlist',
                            'remove-from-comparelist',
                            'add-to-comparelist',
                            'signup',
                            'signup-submit',
                            'login',
                            'login-submit',
                            'change-currency',
                            'change-lang',
                            'test',
                            'recalculate',
                            'cart-form-submit',
                            'accept-blog-comment',
                            'order-detail'

                        ],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
        ];
    }

    public $layout = '/shop';

    public function actionLogin()
    {
        $data = $this->getCommonDate();

        return $this->render('login', [
            'data' => $data,
        ]);
    }

    public function actionSignupSubmit()
    {
        if (isset(Yii::$app->request->post('SignupForm')['checkbox'])) {
            $IsLogin = true;
        } else {
            $IsLogin = false;
        }

        $model = new SignupForm;
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user = $model->signup() && $IsLogin) {

                // если есть чекбокс залогинить
                $model->login($user);
                return $this->redirect('/shop/index');

            } else {
                // если не просили залогинить
                //vd(yii::$app->request->isAjax);

                Yii::$app->response->format = Response::FORMAT_JSON;

                Yii::$app->getSession()->setFlash('success', 'Вы успешно зарегистрировались');
                return $this->redirect('/shop/index');

            }
        }

        return $this->redirect('/shop/signup');
    }

    public function actionSignup()
    {
        $data = $this->getCommonDate();

        return $this->render('signup', [
            'data' => $data,
        ]);
    }

    public function actionIndex()
    {
        $data = $this->getCommonDate();

        $modelSlider = Goods::find()->all();
        $modelBest = Goods::getBest(3);
        $modelNewGoods = Goods::getNewest(6);
        $modelGoodsCategories = GoodsCategory::find()->all();
        $modelBrends = Brend::find()->all();
        $modelBanner = Banner::find()->where(['status' => 0])->all();
        return $this->render('index',
            [
                'data' => $data,
                'modelNewGoods' => $modelNewGoods,
                'modelGoodsCategories' => $modelGoodsCategories,
                'modelSlider' => $modelSlider,
                'modelBest' => $modelBest ? $modelBest : false,
                'modelBanner' => $modelBanner,
                'modelBrends' => $modelBrends]);
    }

    public function actionWishlist()
    {
        $data = $this->getCommonDate();


        $modelSlider = Goods::find()->all();
        $modelBest = Goods::getBest(3);
        $modelNewGoods = Goods::getNewest(6);
        $modelGoodsCategories = GoodsCategory::find()->all();
        $modelBrends = Brend::find()->all();
        return $this->render('wishlist',
            [
                'data' => $data,
                'modelNewGoods' => $modelNewGoods,
                'modelGoodsCategories' => $modelGoodsCategories,
                'modelSlider' => $modelSlider,
                'modelBest' => $modelBest,
                'modelBrends' => $modelBrends,

            ]);
    }

    public function actionComparelist()
    {
        $data = $this->getCommonDate();

        $modelSlider = Goods::find()->all();
        $modelBest = Goods::getBest(3);
        $modelNewGoods = Goods::getNewest(6);
        $modelGoodsCategories = GoodsCategory::find()->all();
        $modelBrends = Brend::find()->all();

        return $this->render('comparelist',
            [
                'data' => $data,
                'modelNewGoods' => $modelNewGoods,
                'modelGoodsCategories' => $modelGoodsCategories,
                'modelSlider' => $modelSlider,
                'modelBest' => $modelBest,
                'modelBrends' => $modelBrends,
            ]);
    }


    function actionProducts()
    {
        $categoria_id = Yii::$app->request->get('categoria');
        $brand_id = Yii::$app->request->get('brand');

        if ($categoria_id) {
            $query = Goods::find()->where(['status' => 1, 'category_id' => $categoria_id]);
        } elseif ($brand_id) {
            $query = Goods::find()->where(['status' => 1, 'brend_id' => $brand_id]);
        } else {
            $query = Goods::find()->where(['status' => 1]);
        }


        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 2]);
        $modelsGoods = $query->offset($pages->offset)
            ->limit(3)
            ->all();


        $data = $this->getCommonDate();
        $iP = Yii::$app->session->id;
        $quantityInCart = Cart::getQountAllByIp($iP);
        $model = Cart::getAllByIp($iP);
        $modelBrends = Brend::find()->all();
        $modelNewGoods = Goods::getNewest(15);
        $modelGoodsCategories = GoodsCategory::find()->all();
        return $this->render('products', [
            'modelsGoods' => $modelsGoods,
            'pages' => $pages,
            'data' => $data,
            'modelNewGoods' => $modelNewGoods,
            'modelGoodsCategories' => $modelGoodsCategories,
            'model' => $model,
            'modelBrends' => $modelBrends,
            'quantityInCart' => $quantityInCart
        ]);
    }

    public function actionCart()
    {
        $data = $this->getCommonDate();
        $model_form = new Order();
        $iP = Yii::$app->session->id;
        $model = Cart::getAllByIp($iP);


        $model_form = new Order();
        if ($model_form->load(Yii::$app->request->post()) && $model_form->validate()) {


            return $this->render('cart', ['model' => $model]);
        } else {
            return $this->render('cart',
                [
                    'data' => $data,
                    'model' => $model,
                    'model_form' => $model_form
                ]);
        }

    }

    public function actionBlog()
    {
        $countPostOnPage = SetupSite::getParam('countPostOnPage');
        $data = $this->getCommonDate();
        $modelGoodsCategories = GoodsCategory::find()->all();
        $modelBanner = Banner::find()->where(['status' => 0])->all();
        $modelBrends = Brend::find()->all();
        $modelBlog = Blog::find();


        $countQuery = clone $modelBlog;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 3]);
        $models = $modelBlog->offset($pages->offset)
            ->limit($countPostOnPage)
            ->orderBy('created_at DESC')
            ->all();

        return $this->render('blog', [
            'models' => $models,
            'pages' => $pages,
            'data' => $data,
            'modelGoodsCategories' => $modelGoodsCategories,
            'modelBrends' => $modelBrends,
            'modelBanner' => $modelBanner,

        ]);
    }

    public function actionBlogDetail($id)
    {
        $data = $this->getCommonDate();
        $modelGoodsCategories = GoodsCategory::find()->all();
        $modelBanner = Banner::find()->where(['status' => 0])->all();
        $modelBrends = Brend::find()->all();
        $modelBlog = Blog::findOne($id);
        $modelBlogComents = BlogComments::getComentsByBlogId($id);


        return $this->render('blog-detail', [
            'modelBlog' => $modelBlog,
            'data' => $data,
            'modelGoodsCategories' => $modelGoodsCategories,
            'modelBrends' => $modelBrends,
            'modelBanner' => $modelBanner,
            'modelBlogComents'=> $modelBlogComents

        ]);
    }

    public
    function actionContact()
    {
        $data = $this->getCommonDate();
        $iP = Yii::$app->session->id;
        $quantityInCart = Cart::getQountAllByIp($iP);
        $modelReqvizit = Reqvizit::findOne(1);
        return $this->render('contact', [
            'data' => $data,
            'quantityInCart' => $quantityInCart,
            'modelReqvizit' => $modelReqvizit]);
    }


    public
    function actionDetail()
    {
        $data = $this->getCommonDate();

        $modelBest = Goods::getBest(3);
        $iP = Yii::$app->session->id;
        $quantityInCart = Cart::getQountAllByIp($iP);
        $id = Yii::$app->request->get('item');
        $modelReview = Review::getReviewsByGoodId($id);
        $modelGoodsCategories = GoodsCategory::find()->all();
        $modelBrends = Brend::find()->all();
        if (!$id) {
            $this->redirect('/shop/index');
        }
        $model = Goods::getItemById($id);
        $modelPhotos = GoodsPhotos::getItemsByGoodId($id);
        $_modelReview = new Review();

        return $this->render('detail', [
            'modelPhotos' => $modelPhotos,
            'data' => $data,
            'model' => $model,
            'modelGoodsCategories' => $modelGoodsCategories,
            'modelReview' => $modelReview,
            '_modelReview' => $_modelReview,
            'modelBest' => $modelBest,

            'modelBrends' => $modelBrends]);
    }

    // Мой заказ
    public function actionOrder()
    {
        $iP = Yii::$app->session->id;
        if(Yii::$app->user->isGuest){
            Yii::$app->getSession()->setFlash('success', 'Для просмотра истории заказов необходимо войти под своим именем');
            return $this->redirect('/shop/login');
        }
        $data = $this->getCommonDate();
        $email = Yii::$app->user->identity->email;
       // vd($email);
        $model = Order::getAllByLogin($email);
        $quantityInCart = Cart::getQountAllByIp($iP);
        return $this->render('order', ['model' => $model,
            'quantityInCart' => $quantityInCart,
            'data' => $data,
        ]);
    }

    //***************************************** functions **************************************************************
    //Добавляет товар в корзину
    public function actionAddToCart()
    {
        $arrResult = [];
        $iP = Yii::$app->session->id;
        $good_id = Yii::$app->request->post('good_id');
        // если есть этот товар в корзине то просто увеличить его количество на 1
        $isItemInCart = Cart::_isItemAlreadyInCart($good_id);
        if ($isItemInCart) {
            Cart::updateItemQuantityUp($good_id);
        } else {

            $model = new Cart();
            $model->ip = Yii::$app->session->id;
            $model->goods_id = $good_id;
            $model->quantity = 1;
            $model->price = Goods::getPriceById($good_id);
            $model->category_id = Goods::getCategoryById($good_id);
            $model->brend_id = Goods::getBrendById($good_id);
            //$model->validate();
            //vd($model->getErrors());
            $model->save();
        }
        $quantityInCart = Cart::getQountAllByIp($iP);
        $arrResult['quantity'] = $quantityInCart;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $arrResult;

    }

    //Добавляет много товаров  в корзину
    public function actionAddToManyCart()
    {
        $arrResult = [];
        $iP = Yii::$app->session->id;
        $good_id = Yii::$app->request->post('good_id');
        $total = Yii::$app->request->post('total');
        // если есть этот товар в корзине то просто увеличить его количество на 1
        $isItemInCart = Cart::_isItemAlreadyInCart($good_id);
        if ($isItemInCart) {
            Cart::updateItemQuantityUpMany($good_id, $total);
        } else {

            $model = new Cart();
            $model->ip = Yii::$app->session->id;
            $model->goods_id = $good_id;
            $model->quantity = $total;
            $model->price = Goods::getPriceById($good_id);
            $model->category_id = Goods::getCategoryById($good_id);
            $model->brend_id = Goods::getBrendById($good_id);
            //$model->validate();
            //vd($model->getErrors());
            $model->save();
        }
        $quantityInCart = Cart::getQountAllByIp($iP);
        $arrResult['quantity'] = $quantityInCart;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $arrResult;

    }

    //Выведет аяксом все товары этой категории
    public function actionGetGoodsByCategory()
    {
        $category_id = Yii::$app->request->post('category_id');
        $model = Goods::getGoodsByCategoriId($category_id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model) {
            return $this->renderAjax('/ajax/_get-goods-by-category', ['model' => $model]);
        } else {
            return $this->renderAjax('/ajax/_empty');
        }
    }

    //Увеличивает количество товаров на 1 еденицу
    public function actionAddMoreQuantity()
    {
        $arrResult = [];
        $iP = Yii::$app->session->id;
        $good_id = Yii::$app->request->post('good_id');
        $goodPrice = Goods::getPriceById($good_id);
        // vd($good_id);
        $model = Cart::getItemById($good_id);
        $model->quantity = $model->quantity + 1;
        $model->price = $model->price + $goodPrice;
        $model->updateAttributes(['quantity', 'price']);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $quantityInCart = Cart::getQountAllByIp($iP);
        $arrResult['new_quantity'] = $model->quantity;
        $arrResult['new_price'] = $model->price;
        $arrResult['total'] = $quantityInCart;
        return $arrResult;


    }

    //Уменьшает количество товаров на 1 еденицу
    public function actionRemoveMoreQuantity()
    {
        $arrResult = [];
        $iP = Yii::$app->session->id;
        $good_id = Yii::$app->request->post('good_id');
        $goodPrice = Goods::getPriceById($good_id);
        // vd($good_id);
        $model = Cart::getItemById($good_id);
        $model->quantity = $model->quantity - 1;
        $model->price = $model->price - $goodPrice;
        $model->updateAttributes(['quantity', 'price']);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $quantityInCart = Cart::getQountAllByIp($iP);
        $arrResult['new_quantity'] = $model->quantity;
        $arrResult['new_price'] = $model->price;
        $arrResult['total'] = $quantityInCart;
        return $arrResult;


    }

    //Удаляет товар из корзины
    public function actionDeleteFromCart()
    {
        $arrResult = [];
        $good_id = Yii::$app->request->post('good_id');
        $arrResult['result'] = Cart::deleteItemById($good_id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $iP = Yii::$app->session->id;
        $quantityInCart = Cart::getQountAllByIp($iP);
        $arrResult['total'] = $quantityInCart;
        return $arrResult;

    }

    //Верент массив городов
    public function actionGetCities()
    {
        $arrResult = [];
        $country_id = Yii::$app->request->post('country_id');
        $arrCities = GeoCity::find()->where(['country_id' => $country_id])->orderBy('name_ru ASC')->all();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $html = $this->renderAjax('/ajax/_cities', ['arrCities' => $arrCities]);
        $arrResult['html'] = $html;
        return $arrResult;

    }

    // Веренет товары этого бренда
    public function actionGetGoodsByBrend()
    {
        $brend_id = Yii::$app->request->post('brend_id');
        $model = Goods::getGoodsByBrendId($brend_id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model) {
            return $this->renderAjax('/ajax/_get-goods-by-category', ['model' => $model]);
        } else {
            return $this->renderAjax('/ajax/_empty');
        }
    }

    // Создать Заказ
    public function actionMakeOrder()
    {
        //vd(Yii::$app->request->post());
        $model = new Order();
        $model->load(Yii::$app->request->post());
        $model->payment_type = Yii::$app->request->post()['payment'];
        $model->status = 1;
        $model->created_at = time();
        //$model->validate();
        //vd($model->getErrors());
        $model->save();
        $orderId = $model->id;
        $allGoodsFroMCart = Cart::getAllbyIp(Yii::$app->session->id);
        //Todo создать список товаров связв=анных с заказом и сох в отдель таб  по ip
        foreach ($allGoodsFroMCart as $good) {
            $_model = new OrderItems();
            $_model->order_id = $orderId;
            $_model->ip = $good->ip;
            $_model->goods_id = $good->goods_id;
            $_model->quantity = $good->quantity;
            $_model->price = $good->price;
            $_model->category_id = $good->category_id;
            $_model->brend_id = $good->brend_id;
            $_model->save();
            $good->delete();
        }
        //Todo удалить из корзины  товары по ip
    }

    public function actionAddContact()
    {

        $arrResult = [];
        $model = new Contacts();

        $model->ip = Yii::$app->user->id ? Yii::$app->user->id : Yii::$app->session->id;
        $model->user_id = Yii::$app->user->id ? Yii::$app->user->id : Yii::$app->session->id;
        $model->created_at = time();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $arrResult['success'] = 'Сообщение успешно отправленно!';
            return $arrResult;
        } else {
            $model->validate();
            vd($model->getFirstErrors());
            // ошибки
            if (Yii::$app->request->post('Contacts')['content'] == null) {
                $arrResult['error'] = 'Сообщение пусто!';
                return $arrResult;
            }
            if (Yii::$app->request->post('Contacts')['name'] == null) {
                $arrResult['error'] = 'Имя пусто!';
                return $arrResult;
            }
            if (Yii::$app->request->post('Contacts')['email'] == null) {
                $arrResult['error'] = 'email пусто!';
                return $arrResult;
            }
            if (Yii::$app->request->post('Contacts')['subject'] == null) {
                $arrResult['error'] = 'Тема  пуста!';
                return $arrResult;
            }
            $arrResult['error'] = 'Не коректный Email!';
            return $arrResult;
        }
    }

    // Добавляет товар в список желаний
    public function actionAddToWishlist()
    {
        $arrResult = [];
        $good_id = Yii::$app->request->post('good_id');

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $isItemInWishList = Wishlist::_isItemAlreadyIn($good_id, Yii::$app->session->id);
        if ($isItemInWishList) {
            $arrResult['error'] = 'Товар уже в списке желаний';
            return $arrResult;
        }
        $model = new Wishlist();
        $model->ip = Yii::$app->session->id;
        $model->goods_id = $good_id;
        $model->created_at = time();
        $model->price = Goods::getPriceById($good_id);
        $model->category_id = Goods::getCategoryById($good_id);
        $model->brend_id = Goods::getBrendById($good_id) ? Goods::getBrendById($good_id) : null;
        //$model->validate();
        //vd($model->getErrors());


        if ($model->save()) {
            $arrResult['success'] = 'Товар добавлен в список желаний!';
            $quantityInWishList = count(Wishlist::getListByIp(Yii::$app->session->id));
            $arrResult['quantity'] = $quantityInWishList;

        } else {
            //$model->validate();
            //vd($model->getErrors());
            $arrResult['error'] = 'Ошибка добавления товара!';
        }
        return $arrResult;
    }

    // Добавляет товар в список желаний
    public function actionAddToComparelist()
    {
        $arrResult = [];
        $good_id = Yii::$app->request->post('good_id');

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $isItemInCompareList = Compare::_isItemAlreadyIn($good_id, Yii::$app->session->id);
        if ($isItemInCompareList) {
            $arrResult['error'] = 'Товар уже в списке сравнений';
            return $arrResult;
        }
        $model = new Compare();
        $model->ip = Yii::$app->session->id;
        $model->goods_id = $good_id;
        $model->created_at = time();
        $model->price = Goods::getPriceById($good_id);
        $model->category_id = Goods::getCategoryById($good_id);
        $model->brend_id = Goods::getBrendById($good_id) ? Goods::getBrendById($good_id) : null;
        //$model->validate();
        //vd($model->getErrors());


        if ($model->save()) {
            $arrResult['success'] = 'Товар добавлен в список сравнения!';
            $quantityInCompareList = count(Compare::getListByIp(Yii::$app->session->id));
            $arrResult['quantity'] = $quantityInCompareList;

        } else {
            //$model->validate();
            //vd($model->getErrors());
            $arrResult['error'] = 'Ошибка добавления товара!';
        }
        return $arrResult;
    }


    // Удаляет товар в список желаний
    public function actionRemoveFromWishlist()
    {
        $iP = Yii::$app->session->id;
        $arrResult = [];
        $good_id = Yii::$app->request->post('good_id');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $isItemInWishList = Wishlist::_isItemAlreadyIn($good_id, $iP);
        if ($isItemInWishList) {
            $model = Wishlist::getItemByGoodId($good_id, $iP);
            $model->delete();
            $modelWishList = WishList::getListByIp($iP);
            $quantityWishlist = $modelWishList ? count($modelWishList) : '';
            $arrResult['success'] = 'Товар удален из списка желаний!';
            $arrResult['quantity'] = $quantityWishlist;
        } else {
            $arrResult['error'] = 'Ошибка удаления товара!';
        }

        return $arrResult;
    }

    // Удаляет товар в список сранений
    public function actionRemoveFromComparelist()
    {
        $iP = Yii::$app->session->id;
        $arrResult = [];
        $good_id = Yii::$app->request->post('good_id');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $isItemInCompareList = Compare::_isItemAlreadyIn($good_id, Yii::$app->session->id);
        if ($isItemInCompareList) {
            $model = Compare::getItemByGoodId($good_id, $iP);
            $model->delete();
            $modelCompareList = Compare::getListByIp($iP);
            $quantityCompareList = $modelCompareList ? count($modelCompareList) : '';
            $arrResult['success'] = 'Товар удален из списка желаний!';
            $arrResult['quantity'] = $quantityCompareList;
        } else {
            $arrResult['error'] = 'Ошибка удаления товара!';
        }

        return $arrResult;
    }

    public function actionLoginSubmit()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm;
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->login();
            return $this->redirect('/shop/index');
        }
        return $this->goHome();

    }

    /*
     *  Смена валюты
     */
    public function actionChangeCurrency()
    {
        $arrResult = [];
        $cur = Yii::$app->request->post('cur');
        //vd($cur);
        $new_curency = Setup::changeCurrencyTo($cur);
        Yii::$app->response->format = Response::FORMAT_JSON;
        switch ($new_curency) {
            case 1:
                $new_curency = 'RUB';
                break;
            case 2:
                $new_curency = 'DOLLAR';
                break;
            case 3:
                $new_curency = 'UAN';
                break;
        }
        $arrResult['new_currency'] = $new_curency . '<span class="caret"></span>';
        return $arrResult;

    }

    /*
     *  Смена языка
     */
    public function actionChangeLang()
    {
        $arrResult = [];
        $lang = (int)Yii::$app->request->post('lang');

        $new_lang = Setup::changeLangTo($lang);
        Yii::$app->response->format = Response::FORMAT_JSON;
        switch ($new_lang) {
            case 1:
                $new_lang = 'RU';
                Yii::$app->language = 'ru-RU';
                break;
            case 2:
                $new_lang = 'EN';
                Yii::$app->language = 'en_US';
                break;
        }
        $arrResult['new_lang'] = $new_lang . '<span class="caret"></span>';
        return $arrResult;

    }

    // получаю все данные
    private function getCommonDate()
    {

        $currCurency = Setup::getCurrCurency();
        $data['currCurency'] = $currCurency;

        $currLang = Setup::getCurrLang();
        $data['currLang'] = $currLang;


        $iP = Yii::$app->session->id;
        $modelWishList = WishList::getListByIp($iP);
        $quantityWishlist = $modelWishList ? count($modelWishList) : '';
        $data['quantityWishlist'] = $quantityWishlist;
        $data['modelWishList'] = $modelWishList;


        $modelCompareList = Compare::getListByIp($iP);
        $quantityCompareList = $modelCompareList ? count($modelCompareList) : '';
        $data['quantityCompareList'] = $quantityCompareList;
        $data['modelCompareList '] = $modelCompareList;

        $quantityInCart = Cart::getQountAllByIp($iP);
        $data['quantityInCart'] = $quantityInCart;

        return $data;
    }

    public function actionTest()
    {
        return $this->render('test');
    }

    public function actionRecalculate()
    {
        $iP = Yii::$app->session->id;
        $model = Cart::getAllByIp($iP);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->renderAjax('_ajax_recalculate', ['model' => $model]);
    }

    public function actionCartFormSubmit()
    {
        {


            if (Yii::$app->request->isPost) {
                $model_form = new Order();
                $model_form->load(Yii::$app->request->post());
                $model_form->scenario = 'submit';
                $model_form->payment_type = Yii::$app->request->post('payment') ? Yii::$app->request->post('payment') : 0;
                //$model_form->validate();
                //vd( $model_form->getErrors());
                $model_form->status = 1;


            }
            if ($model_form->load(Yii::$app->request->post()) && $model_form->validate()) {
                $model_form->save();
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                Yii::$app->session->setFlash('success', 'Благодарим за покупку');
                //Todo сохранить заказы !!!

                $iP = Yii::$app->session->id;
                $model = Cart::getAllByIp($iP);
                if ($model) {
                    //vd($model_form->created_at);
                    $listItemsInOrder = OrderItems::Add($model, $model_form->id, $model_form->created_at);
                    //vd($listItemsInOrder);
                }
                //Todo отправка email !!!
                // Todo отправка ел почты
                //$model_Email = Email::find()->where(['id' => 1])->one();
                // $currEmail = $model_Email->email;
                //vd($model->email);

                Yii::$app->mailer->compose(['html' => '@common/mail/order'], ['order_id' => $model_form->id, 'listItemsInOrder' => $listItemsInOrder])
                    ->setFrom('kotmonstr@local.com')
                    ->setTo('kotmonstr@ukr.net')
                    ->setSubject('нОвый заказ')
                    //->setTextBody('Plain text content')
                    //->setHtmlBody('<b>Kotmonstr.ru</b>')
                    ->send();
                //Todo Очистить корзину
                 Cart::DeleteAllByIp($iP);

                $this->redirect('/site/index');
            } else {
                // либо страница отображается первый раз, либо есть ошибка в данных
                $data = $this->getCommonDate();
                $model_form = new Order();
                $iP = Yii::$app->session->id;
                $model = Cart::getAllByIp($iP);


            }
            return $this->render('cart',
                [
                    'data' => $data,
                    'model' => $model,
                    'model_form' => $model_form
                ]);

        }
    }

    public function actionAcceptBlogComment()
    {
        $model = new BlogComments();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $model->validate();
//            vd($model->getErrors());
            $model->save();
            $this->redirect('/shop/blog-detail?id='.$model->blog_id);
        }else{
            //$this->refresh();
        }

    }
    public function actionOrderDetail($id){
        $modelOrder = Order::getOrderById($id);
        $modelOrderDetail = OrderItems::getOrderDetailById($id);
        $data = $this->getCommonDate();
        return $this->render('order-detail',
            [
            'data' => $data,
            'modelOrder'=> $modelOrder,
            'modelOrderDetail'=> $modelOrderDetail
            ]
        );
    }
}