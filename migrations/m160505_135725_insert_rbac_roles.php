<?php

use yii\db\Migration;

class m160505_135725_insert_rbac_roles extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->getAuthManager();
        $authManager->createRole('Administrator');
        $authManager->createRole('Moderator');
    }

    public function down()
    {
        $authManager = Yii::$app->getAuthManager();
        $authManager->removeAllRoles();
    }
}
