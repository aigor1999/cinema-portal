<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
        ], $tableOptions);

        //добавление тестового пользователя
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'auth_key' => Yii::$app->security->generateRandomString()
        ]);

        $this->createTable('{{%film}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'photo_type' => $this->string()->notNull(),
            'description' => $this->text(),
            'length' => $this->smallInteger()->notNull()->check("length > 0 AND length <= 240"),
            'rating' => $this->string(3)->notNull()->check("rating IN ('0+', '6+', '12+', '16+', '18+')")
        ], $tableOptions);

        $this->createTable('{{%seance}}', [
            'id' => $this->primaryKey(),
            'film_id' => $this->integer()->notNull(),
            'datetime' => $this->dateTime()->notNull(),
            'price' => $this->smallInteger()->notNull()->check("price > 0 AND price <= 10000")
        ], $tableOptions);

        $this->addForeignKey(
            'fk-seance-film_id',
            '{{%seance}}',
            'film_id',
            '{{%film}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%seance}}');
        $this->dropTable('{{%film}}');
        $this->dropTable('{{%user}}');
    }
}
