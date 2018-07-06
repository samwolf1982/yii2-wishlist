<?php

use yii\db\Schema;
use yii\db\Migration;

class m160518_074611_wishlist extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%wishlist}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(11),
                'token' => $this->string(255)->notNull(),
                'token_expire' => $this->date(),
                'model' => $this->string(255)->notNull(),
                'item_id' => $this->integer(11)->notNull(),
                'type' => $this->integer(11)->defaultValue(0),
                ],
            $tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%wishlist}}');
    }
}
