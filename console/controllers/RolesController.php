<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RolesController extends Controller
{
    public function actionIndex()
    {
        $roles = ['admin', 'pelanggan'];
        foreach ($roles as $roleName) {
            $role = Yii::$app->authManager->createRole($roleName);
            $role->description = ucwords($roleName);
            Yii::$app->authManager->add($role);
        }
    }

    public function actionDefaultAdmin()
    {
        $userRole = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->revokeAll(1);
        Yii::$app->authManager->assign($userRole, 1);
    }
}
