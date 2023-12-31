<?php

use yii\db\Migration;

/**
 * Class m231023_142820_create_file
 */
class m231023_142820_create_file extends Migration
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
            'files',
            [
                'id'               => $this->primaryKey(),
                'dir'              => $this->string(32)->notNull(),
                'path'             => $this->string(64)->notNull(),
                'file_name'        => $this->string(128)->notNull(),
                'file_source_name' => $this->string(128)->notNull(),
                'file_source_time' => $this->integer(11)->notNull()->defaultValue(0),
                'file_source_url'  => $this->string(256)->null(),
                'created_at'       => $this->datetime()->null(),
            ],
            $tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231023_142820_create_file cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231023_142820_create_file cannot be reverted.\n";

        return false;
    }
    */
}
