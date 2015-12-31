<?php

namespace app\controllers;

use app\assets\AppAsset;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'about', 'contact', 'tab', 'index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        AppAsset::register($this->view);
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTab($exp = 'intact')
    {
        $experiments = Yii::$app->params['experiments'];

        if( ! isset($experiments[$exp]) ) {
            return 'Not implemented';
        }

        if ( $experiments[$exp]['login'] && Yii::$app->user->isGuest ) {
            return "No access";
        }

        if (isset($experiments[$exp]['experimentalSetup']) ) {
            $experimentalSetupFile = Yii::getAlias('@app') . '/experimentalsetup/' . $experiments[$exp]['experimentalSetup']['file'];

            if (file_exists($experimentalSetupFile)) {
                $experiments[$exp]['experimentalSetup']['contents'] = file_get_contents($experimentalSetupFile);
            } else {
                $experiments[$exp]['experimentalSetup']['contents'] = "Could not load experimental setup file: " . $experiments[$exp]['experimentalSetup']['file'];
            }
        }

        return $this->renderPartial('/experiments/' . $experiments[$exp]['template'], [
            'experimentName' => $exp,
            'config' => $experiments[$exp]
        ]);

    }
}
