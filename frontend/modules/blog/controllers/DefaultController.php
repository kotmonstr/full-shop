<?php

namespace app\modules\blog\controllers;


use yii\imagine\Image;
use yii\web\Controller;
use common\models\Blog;
use Yii;
use common\models\BlogSearch;
use yii\data\Pagination;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use common\models\Comment;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use vova07\imperavi\actions\GetAction;
use yii\web\Response;
use frontend\components\WaterMark;
class DefaultController extends Controller {
     public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
             'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete','create-image','quick-upload','upload','uploaded'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index','view','show','views'],
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '/frontend/web/upload/imp/', // URL адрес папки куда будут загружатся изображения.
                'path' => Yii::getAlias('@frontend') . '/web/upload/imp' // Или абсолютный путь к папке куда будут загружатся изображения.
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                //'url' => '/frontend/web/upload/imp/', // URL адрес папки куда будут загружатся изображения.
                'path' => Yii::getAlias('@frontend') . '/web/upload/imp',// Или абсолютный путь к папке куда будут загружатся изображения.
                'type' => GetAction::TYPE_IMAGES,
            ]
        ];
    }



    public $layout = '/blog';

    public function actionIndex() {
        //$this->layout = '/blog';
        // Вывести список статей

        $query = Blog::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 5]);
        $models = $query->offset($pages->offset)
                ->orderBy('id DESC')
                ->limit($pages->limit)
                ->all();

        $modelLastBlog = Blog::find()
            ->orderBy('id DESC')
            ->limit(5)
            ->all();

        $modeMostWatched = Blog::find()
            ->orderBy('view DESC')
            ->limit(5)
            ->all();


        return $this->render('index', [ 'model' => $models,
                            'modelLastBlog'=> $modelLastBlog,
                            'modeMostWatched'=> $modeMostWatched,
                            'pages' => $pages]);
    }

    public function actionView() {
        $this->layout = '/adminka-admin';
        $id = Yii::$app->request->get('id');
        $blog = $this->findModel($id);
        //$blog = Blog::find()->where(['id' => $id])->one();
        return $this->render('view', ['model' => $blog]);
    }

    public function actionShow() {
        $this->layout = '/adminka-admin';
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('show', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $this->layout = '/adminka-admin';
        $model = new Blog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id) {
        $this->layout = '/adminka-admin';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id) {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCreateImage() {
        FileHelper::createDirectory(Yii::getAlias('@frontend') . '/web/upload/blog');
        $model = new Blog();
        $name = date("dmYHis", time());
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs('upload/blog/' . $name . '.' . $model->file->extension);
            $full_name = $name . '.' . $model->file->extension;
            return '/upload/blog/' . $full_name;
        }
    }

    public function actionViews($id) {
        $this->layout = '/blog';


        $id = Yii::$app->request->get('id');
        $blog = Blog::find()->where(['id' => $id])->one();
        $viwsQuantity =(int)$blog->view;
        $blog->view = $viwsQuantity +1;
        $blog->updateAttributes(['view']);
        $coment_model = Comment::find()->where(['blog_id'=>$id])->all();
        return $this->render('views', ['model' => $blog,'coment_model'=> $coment_model]);
    }

    // Вернет только что загруженное фото
    public function actionUpload()
    {
        $uploaddir = Yii::getAlias('@frontend') . '/web/upload/imp/';
        $file = md5(date('YmdHis')).'.'.pathinfo(@$_FILES['file']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file(@$_FILES['file']['tmp_name'], $uploaddir.$file)) {
            $array = array(
                'filelink' => '/upload/imp/'.$file
            );
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $array;
    }

// Вернет уже загруженные файлы
    public function actionUploaded()
    {
        $uploaddir = Yii::getAlias('@frontend') . '/web/upload/imp/';
        $arr = scandir($uploaddir);
        $i=0;
        foreach($arr as $key =>  $val){
            $i++;
            if( $i > 2 ) {
                $array['filelink' . $i]['thumb'] = '/upload/imp/' . $val;
                $array['filelink' . $i]['image'] = '/upload/imp/' . $val;
                $array['filelink' . $i]['title'] = '/upload/imp/' . $val;
            }
        }
        $array = stripslashes(json_encode($array));
        return $array;
    }

    // Загрузка фоток в один клик
    public function actionQuickUpload()
    {
        FileHelper::createDirectory(Yii::getAlias('@frontend') . '/web/upload/blog');
        $model = new Blog();
        if (Yii::$app->request->isPost) {
            $imgObject = UploadedFile::getInstance($model, 'file');
            //vd($imgObject);
            $imgObject->saveAs('upload/blog/' . $imgObject->baseName . '.' . $imgObject->extension);
            //
            //ToDo Создать Wanermark
            $file = Yii::getAlias('@frontend').'/web/upload/blog/' . $imgObject->baseName . '.' . $imgObject->extension;
           //vd(Yii::getAlias('@frontend').'/web/img/404.jpg');

             $w = new WaterMark(Yii::getAlias('@frontend').'/web/img/water-stamp.png');
             $w->setPosition(WaterMark::POS_RIGHT_DOWN);
             $path = $w->setStamp($file, true);
            return $path;
        }
    }

}
