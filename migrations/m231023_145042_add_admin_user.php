<?php

use yii\db\Migration;

/**
 * Class m231023_145042_add_admin_user
 */
class m231023_145042_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'status'        => 1,
            'role'          => 'admin',
            'username'      => 'admin',
            'telegram'      => 'admin',
            'password_hash' => '$2y$13$HZoREgc4F.4J50s2CEmiMu42.vgpyLQVUEQHPhvGxOSiRgRtzF/4q' //admin pass rU66Xm84xiFvTV79Ce6g
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231023_145042_add_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231023_145042_add_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
