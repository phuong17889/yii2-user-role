<?php
use yii\db\Migration;
use yii\db\mysql\Schema;
use yii\helpers\Json;

class m160226_063609_create_role extends Migration {

	public function up() {
		$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		$this->createTable('{{%role}}', [
			'id'               => $this->primaryKey(),
			'name'             => Schema::TYPE_STRING . '(255) NOT NULL',
			'permissions'      => Schema::TYPE_TEXT . ' NOT NULL',
			'is_backend_login' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT "0"',
		], $tableOptions);
		$this->addColumn('{{%user}}', 'role_id', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT "1"');
		$this->insert('{{%role}}', [
			'name'             => 'Administrator',
			'permissions'      => Json::encode([
				'navatech\role\controllers\DefaultController' => [
					'index'  => 1,
					'create' => 1,
					'update' => 1,
					'delete' => 1,
				],
			]),
			'is_backend_login' => 1,
		]);
		$this->insert('{{%role}}', [
			'name'             => 'Staff',
			'permissions'      => Json::encode([
				'navatech\role\controllers\DefaultController' => [
					'index'  => 0,
					'create' => 0,
					'update' => 0,
					'delete' => 0,
				],
			]),
			'is_backend_login' => 1,
		]);
		$this->insert('{{%role}}', [
			'name'             => 'Member',
			'permissions'      => '',
			'is_backend_login' => 0,
		]);
		$this->addForeignKey('fk_user_role_id', '{{%user}}', 'role_id', '{{%role}}', 'id', 'CASCADE', 'CASCADE');
	}

	public function down() {
		$this->dropTable('{{%role}}');
		$this->dropColumn('{{%user}}', 'role_id');
	}
}
