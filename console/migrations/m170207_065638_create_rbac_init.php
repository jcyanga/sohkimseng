<?php

use yii\db\Migration;

class m170207_065638_create_rbac_init extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $technician = $auth->createRole('technician');
        $technician->description = 'Technician';
        $auth->add($technician);

        $driver = $auth->createRole('driver');
        $driver->description = 'Driver';
        $auth->add($driver);

        $sales = $auth->createRole('sales');
        $sales->description = 'Sales';
        $auth->add($sales);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $developer = $auth->createRole('developer');
        $developer->description = 'Developer';
        $auth->add($developer);
    }

    public function down()
    {
        Yii::$app->authManager->removeAll();
        // echo "m170207_065638_create_rbac_init cannot be reverted.\n";

        // return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
