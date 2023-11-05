<?php

use yii\db\Migration;

/**
 * Class m231024_125750_create_prediction
 */
class m231024_125750_create_prediction extends Migration
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
            'prediction',
            [
                'id'              => $this->primaryKey(),
                'status'          => $this->integer(1)->notNull(),
                'points_okup'     => $this->integer(11)->null(),
                'points_ne_okup'  => $this->integer(11)->null(),
                'percent_okup'    => $this->decimal(8,0)->null(),
                'percent_ne_okup' => $this->decimal(8,0)->null(),
                'kf_okup'         => $this->decimal(8,2)->null(),
                'kf_ne_okup'      => $this->decimal(8,2)->null(),
            ],
            $tableOptions
        );

        $this->insert('prediction', [
            'status'          => 0,
            'points_okup'     => 0,
            'points_ne_okup'  => 0,
            'percent_okup'    => 0,
            'percent_ne_okup' => 0,
            'kf_okup'         => 0.00,
            'kf_ne_okup'      => 0.00,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m231024_125750_create_prediction cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231024_125750_create_prediction cannot be reverted.\n";

        return false;
    }
    */
}
