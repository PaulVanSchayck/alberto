<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Gene;
use yii\web\Response;

class GeneController extends Controller {

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    function actionIndex()
    {
        return Gene::find()->limit(10)->all();
    }
} 