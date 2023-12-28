<?php

namespace backend\controllers;

use backend\models\DialogflowHistoryForm;
use common\models\DialogflowHistory;
use common\search\DialogflowHistorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class HistoryController extends \yii\web\Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors()
        );
    }

    public function actionIndex()
    {
        $searchModel = new DialogflowHistorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Pelanggan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new DialogflowHistoryForm();

        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }

            if ($model->saveData()) {
                Yii::$app->session->setFlash('noticeSuccess', "Data berhasil disimpan");
            } else {
                Yii::$app->session->setFlash('noticeFailed', "Data gagal disimpan");
            }
            $route = Yii::$app->request->referrer;
            return $this->redirect($route);
        }

        $data['model'] = $model;

        return $this->renderAjax('form', $data);
    }

    public function actionView($trace)
    {
        $data['data'] = DialogflowHistory::find()
            ->where([
                'trace' => $trace
            ])
            ->orderBy([
                'timestamp' => SORT_ASC,
            ])
            ->all();
        return $this->render("detail", $data);
    }
}
