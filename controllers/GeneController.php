<?php
namespace app\controllers;

use app\components\Scroller;
use Yii;
use app\models\GeneRequest;
use app\components\ActiveDataProvider;
use app\components\Serializer;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'autocomplete', 'export'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    function actionIndex($exp)
    {
        $experiments = Yii::$app->params['experiments'];

        if( isset($experiments[$exp]) ) {
            /* @var $model \yii\db\ActiveRecord */
            $model = $experiments[$exp]['model'];
        } else {
            return 'Not implemented';
        }

        if ( $experiments[$exp]['login'] && Yii::$app->user->isGuest ) {
            return "No access";
        }

        $GeneRequest = new GeneRequest();
        $GeneRequest->setTable($model::tableName());

        if( $GeneRequest->load(Yii::$app->request->post()) && $GeneRequest->validate()) {

            $dataProvider = new ActiveDataProvider([
                'query' => $model::find()
                    ->select($GeneRequest->getColumns())
                    ->joinWith('gene')
                    ->filterWhere($GeneRequest->getFilter())
                    // The next line filters any genes where there is no corresponding gene
                    ->andWhere('gene.agi != ""')
                    ->orderBy($GeneRequest->getOrder()),
                'pagination' => new Scroller($GeneRequest->getPaginationConfig())
            ]);

            $serializer = new Serializer(['collectionEnvelope' => "data", 'extraFields' => ['gene']]);

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

    function actionExport($exp)
    {
        $experiments = Yii::$app->params['experiments'];

        if( isset($experiments[$exp]) ) {
            /* @var $model \yii\db\ActiveRecord */
            $model = $experiments[$exp]['model'];
        } else {
            return 'Not implemented';
        }

        if ( $experiments[$exp]['login'] && Yii::$app->user->isGuest ) {
            return "No access";
        }

        $GeneRequest = new GeneRequest();
        $GeneRequest->setTable($model::tableName());

        if( $GeneRequest->load(Yii::$app->request->post()) && $GeneRequest->validate()) {

            $dataProvider = new ActiveDataProvider([
                'query' => $model::find()
                    ->select($GeneRequest->getVisibleColumns())
                    ->joinWith('gene')
                    ->filterWhere($GeneRequest->getFilter())
                    ->orderBy($GeneRequest->getOrder()),
                'pagination' => new Scroller([
                    'pageSize' => $GeneRequest->length,
                    'offset' => 0,
                    'draw' => 0
                ])
            ]);

            if ( $GeneRequest->includeAnnotations ) {
                $extraFields = ['gene'];
            } else {
                $extraFields = [];
            }

            $serializer = new Serializer(['extraFields' => $extraFields]);

            Yii::$app->response->formatters['csv'] = 'app\components\CsvResponseFormatter';
            Yii::$app->response->format = 'csv';

            return $serializer->serialize($dataProvider);
        } else {
            return $GeneRequest->getErrors();
        }
    }
} 