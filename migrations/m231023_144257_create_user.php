<?php

use yii\db\Migration;

/**
 * Class m231023_144257_create_user
 */
class m231023_144257_create_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            'user',
            [
                'id'            => $this->primaryKey(),
                'status'        => $this->integer(1)->notNull(),
                'role'          => $this->string(64)->notNull(),
                'username'      => $this->string(32)->notNull()->unique(),
                'telegram'      => $this->string(32)->notNull()->unique(),
                'auth_key'      => $this->string(64)->null(),
                'password_hash' => $this->string(64)->null(),
                'avatar_id'     => $this->integer(11)->null(),
                'points'        => $this->integer(11)->null(),
                'user_ip'       => $this->string(64)->null(),
                'created_at'    => $this->dateTime()->null(),
                'updated_at'    => $this->dateTime()->null(),
            ],
            $tableOptions
        );

        $this->createIndex(
            'idx-user-avatar_id',
            'user',
            'avatar_id'
        );

        $this->addForeignKey(
            'fk-user-avatar_id',
            'user',
            'avatar_id',
            'files',
            'id',
            'SET NULL',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231023_144257_create_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231023_144257_create_user cannot be reverted.\n";

        return false;
    }
    */
}
