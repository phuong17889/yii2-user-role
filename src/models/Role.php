<?php
namespace navatech\role\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $permissions
 * @property string  $modules
 */
class Role extends ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'role';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[
				[
					'name',
					'permissions',
					'modules',
				],
				'required',
			],
			[
				[
					'permissions',
					'modules',
				],
				'string',
			],
			[
				['name'],
				'string',
				'max' => 255,
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id'          => 'ID',
			'name'        => 'Name',
			'permissions' => 'Permissions',
			'modules'     => 'Modules',
		];
	}
}
