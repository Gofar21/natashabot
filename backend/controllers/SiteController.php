<?php

namespace backend\controllers;

use common\components\GoogleLoggingApiData;
use common\models\DialogflowHistory;
use common\models\LoginForm;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'logging'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $intentCount = [];
        // $intentConfidence = $reso
        $data['per_intent'] = (new Query)
            ->select(['intent_name', 'jumlah' => new Expression("count(*)")])
            ->from(DialogflowHistory::tableName())
            ->where(['labels_type' => 'dialogflow_response'])
            ->andWhere(new Expression('intent_name is not null'))
            ->andWhere(new Expression('date(timestamp) >= date(DATE_SUB(NOW(), INTERVAL 1 MONTH))'))
            ->andWhere(['!=', 'intent_name', 'Default Welcome Intent'])
            ->groupBy(['intent_name'])
            ->orderBy(['jumlah' => SORT_DESC])
            ->limit(10)
            ->all();
        $tanggal = date_create('now + 1 day');
        $data['range_tanggal'] = [];
        $data['per_hari'] = [];
        for ($i = 0; $i < 30; $i++) {
            date_sub($tanggal, date_interval_create_from_date_string("1 days"));
            $tgl = date_format($tanggal, "Y-m-d");
            $data['range_tanggal'][] = $tgl;
            $data['per_hari'][] = (new Query)
                ->from(DialogflowHistory::tableName())
                ->andWhere(['date(timestamp)' => $tgl])
                ->andWhere(['!=', 'intent_name', 'Default Welcome Intent'])
                ->count('distinct trace') ?: 0;
        }
        $data['range_tanggal']  = array_reverse($data['range_tanggal']);
        $data['per_hari']  = array_reverse($data['per_hari']);

        // echo "<pre>";
        // print_r($data['range_tanggal']);
        // exit();
        return $this->render('index', $data);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
