<?php
namespace app\controllers;

use app\components\Scroller;
use app\models\Intact;
use Yii;
use app\models\GeneRequest;
use app\components\ActiveDataProvider;
use app\components\Serializer;
use yii\helpers\ArrayHelper;
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

        if( $GeneRequest->load(Yii::$app->request->post()) && $GeneRequest->validate()) {

            $dataProvider = new ActiveDataProvider([
                'query' => Intact::find()->select($GeneRequest->getColumns())->joinWith('gene')->filterWhere($GeneRequest->getFilter())->orderBy($GeneRequest->getOrder()),
                'pagination' => new Scroller($GeneRequest->getPaginationConfig())
            ]);

            $serializer = new Serializer(['collectionEnvelope' => "data"]);

            return $serializer->serialize($dataProvider);
        } else {
            return $GeneRequest->getErrors();
        }
    }

    function actionAutocomplete($q)
    {
        $results = Gene::find()->select(['agi','gene'])->where(
            ['or',['like','agi', $q], ['like','gene', $q]]
        )->limit(10)->all();

        return ArrayHelper::toArray($results);
    }
} 