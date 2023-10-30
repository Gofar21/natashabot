<?php

namespace backend\controllers;

use common\models\User;
use common\search\UserSearch;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
        // return $this->render('form', [
        //     'model' => $this->findModel($id),
        //     'readOnly' => true
        // ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = 'json';
                return \yii\widgets\ActiveForm::validate($model);
            }
            if (empty($model->auth_key)) {
                $model->generateAuthKey();
            }
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            }

            $route = "";
            if ($model->save()) {
                $userRole = Yii::$app->authManager->getRole($model->role);
                Yii::$app->authManager->revokeAll($model->id);
                Yii::$app->authManager->assign($userRole, $model->id);

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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
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
            if (!empty($model->password)) {
                $model->setPassword($model->password);
            }

            if ($model->save()) {
                $userRole = Yii::$app->authManager->getRole($model->role);
                Yii::$app->authManager->revokeAll($model->id);
                Yii::$app->authManager->assign($userRole, $model->id);

                Yii::$app->session->setFlash('noticeSuccess', "Data berhasil disimpan");
            } else {
                Yii::$app->session->setFlash('noticeFailed', "Data gagal disimpan");
            }
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $roles = Yii::$app->authManager->getRolesByUser($model->id);
            foreach ($roles as $role) {
                $model->role = $role->name;
            }
        }

        $data['model'] = $model;

        return $this->renderAjax('form', $data);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
