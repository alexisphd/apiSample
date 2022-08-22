<?php

use yii\db\Migration;

/**
 * Class m220822_180927_numbers_table
 */
class m220822_180927_numbers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=101';
        }

        $this->createTable('{{%randoms}}', [
            'id' => $this->primaryKey(), // For mysql eq.: int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT
            'rndNumber' => $this->integer()->notNull()->comment('Псевдослучайное'),

        ], $tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%randoms}}');
    }

}
