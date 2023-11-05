<?php

use yii\db\Migration;

/**
 * Class m231024_175133_create_prediction_bet
 */
class m231024_175133_create_prediction_bet extends Migration
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
            'prediction_bet',
            [
                'id'              => $this->primaryKey(),
                'prediction_type' => $this->integer(1)->notNull(),
                'username'        => $this->string(32)->notNull()->unique(),
                'points'          => $this->integer(11)->notNull(),
            ],
            $tableOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231024_175133_create_prediction_bet cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231024_175133_create_prediction_bet cannot be reverted.\n";

        return false;
    }
    */
}
