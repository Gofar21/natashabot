<?php

namespace backend\controllers;

use common\models\Produk;
use common\search\ProdukSearch;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * ProdukController implements the CRUD actions for Produk model.
 */
class ProdukController extends Controller
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
     * Lists all Produk models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProdukSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Produk model.
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
     * Creates a new Produk model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produk();

        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }

            $route = "";
            $model->attachment = UploadedFile::getInstance($model, 'attachment');
            if ($model->save()) {
                $model->upload();
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
     * Updates an existing Produk model.
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

            $model->attachment = UploadedFile::getInstance($model, 'attachment');
            if ($model->save()) {
                $model->upload();
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
     * Deletes an existing Produk model.
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
     * Finds the Produk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produk::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
