<?php
namespace app\controllers;

use Yii;
use app\models\GeneRequest;
use yii\data\ActiveDataProvider;
use app\components\Serializer;
use yii\web\Controller;
use app\models\Gene;
use yii\web\Response;

class GeneController extends Controller {

    /**
     * Forces all responses to JSON
     *
     * @return array
     */
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
        $GeneRequest = new GeneRequest();

        if( $GeneRequest->load(Yii::$app->request->get()) && $GeneRequest->validate()) {

            $dataProvider = new ActiveDataProvider([
                'query' => Gene::find()->orderBy('agi')->offset($GeneRequest->start)->limit($GeneRequest->length),
                'sort' => ['defaultOrder' => 'agi'],
                'pagination' => false
            ]);

            $serializer = new Serializer();
            $serializer->collectionEnvelope = "data";
            $serializer->draw = $GeneRequest->draw;

            return $serializer->serialize($dataProvider);
        } else {
            return $GeneRequest->getErrors();
        }

    }
} 