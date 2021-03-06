<?php

namespace app\modules\site\controllers;

use yii\web\Controller;
use frontend\models\SignupForm;
use Yii;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;
use common\models\ImageSlider;

class DefaultController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login-shop'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'logout-shop'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }


    public function actionIndex()
    {

        //vd($model);
        //return $this->render('index');
        return $this->redirect('/shop/index');
    }

    public function actionTest()
    {

        $this->layout = '/blog';
        $model = new SignupForm();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            //vd($_POST);
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('test', [
            'model' => $model,
        ]);
    }

    public function actionError()
    {
        $this->layout = '/error';
        $exception = \Yii::$app->errorHandler->exception;
        //vd($exception);
        $code = \Yii::$app->errorHandler->exception->statusCode;
        //$message = \Yii::$app->errorHandler->exception->Exception:string;
        //vd($message);
        //$exception2 = \Yii::$app->errorHandler->code;
        return $this->render('error', ['code' => $code, 'exception' => $exception]);
    }

    public function actionLogin()
    {
        $this->layout = '/blog';
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
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLoginShop()
    {
        //vd(1);
        $this->layout = '/shop';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm;
        if (Yii::$app->request->isAjax) {
            //vd(2);
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        //vd(3);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->login();
            return $this->redirect('/shop/index');
        }
        return $this->redirect('/shop/login');
    }

    public function actionSignup()
    {
        $this->layout = '/blog';
        $model = new SignupForm;
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionLogoutShop()
    {
        Yii::$app->user->logout();
        return $this->redirect('/shop/index');
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
            if ($user = $model->signup()) {


                if ($IsLogin) {
                    Yii::$app->getUser()->login($user);
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    Yii::$app->getSession()->setFlash('success', 'Вы успешно зарегистрировались');
                    return $this->redirect('/shop/index');

                } else {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    Yii::$app->getSession()->setFlash('success', 'Вы успешно зарегистрировались');
                    return $this->redirect('/shop/signup');

                }
                return $this->redirect('/shop/signup');
            }

        } else {
            Yii::$app->getSession()->setFlash('error', 'Ошибка при регистрации');
            return $this->redirect('/shop/index');

        }
    }


}
