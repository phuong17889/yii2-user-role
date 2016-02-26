<?php
use yii\db\Migration;
use yii\db\mysql\Schema;

class m160226_063609_create_role extends Migration {

	public function up() {
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		$this->createTable('{{%role}}', [
			'id'               => $this->primaryKey(),
			'name'             => Schema::TYPE_STRING . '(255) NOT NULL',
			'permissions'      => Schema::TYPE_TEXT . ' NOT NULL',
			'is_backend_login' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT "0"',
		], $tableOptions);
		$this->addColumn('{{%user}}', 'role_id', Schema::TYPE_INTEGER . ' NOT NULL');
	}

	public function down() {
		$this->dropTable('{{%role}}');
		$this->dropColumn('{{%user}}', 'role_id');
	}
}