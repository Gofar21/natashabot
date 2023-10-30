<?php

namespace backend\controllers;

use common\models\Reservasi;
use common\search\ReservasiSearch;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * ReservasiController implements the CRUD actions for Reservasi model.
 */
class ReservasiController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Reservasi models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReservasiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reservasi model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
        // return $this->render('view', [
        //     'model' => $this->findModel($id),
        // ]);
    }

    /**
     * Creates a new Reservasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Reservasi();

        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }

            $route = "";
            if ($model->save()) {
                Yii::$app->session->setFlash('noticeSuccess', "Data berhasil disimpan");
                $route = Url::to(['index']) . '?sort=-id';
            } else {
                Yii::$app->session->setFlash('noticeFailed', "Data gagal disimpan");
                $route = Yii::$app->request->referrer;
            }
            return $this->redirect($route);
        }

        $data['model']        = $model;

        return $this->renderAjax('form', $data);
    }

    /**
     * Updates an existing Reservasi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('noticeSuccess', "Data berhasil disimpan");
            } else {
                Yii::$app->session->setFlash('noticeFailed', "Data gagal disimpan");
            }
            return $this->redirect(Yii::$app->request->referrer);
        }

        $data['model'] = $model;

        return $this->renderAjax('form', $data);
    }

    /**
     * Deletes an existing Reservasi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('noticeSuccess', "Data berhasil dihapus");
        } catch (Exception $e) {
            Yii::$app->session->setFlash('noticeFailed', "Data gagal dihapus");
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Reservasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reservasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reservasi::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
