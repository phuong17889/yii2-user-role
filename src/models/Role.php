<?php
namespace navatech\role\models;

use navatech\base\Module;
use navatech\role\helpers\RoleHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $permissions
 * @property integer $is_backend_login
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
				],
				'required',
			],
			[
				['is_backend_login'],
				'integer',
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
			'id'               => Yii::t('app', 'ID'),
			'name'             => Module::hasMultiLanguage() ? RoleHelper::translate('user_role') : 'Nhóm thành viên',
			'permissions'      => Module::hasMultiLanguage() ? RoleHelper::translate('permission') : 'Quyền hạn',
			'is_backend_login' => Module::hasMultiLanguage() ? RoleHelper::translate('is_backend_login') : 'Đăng nhập mục quản trị',
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function beforeSave($insert) {
		if (is_array($this->permissions)) {
			$this->permissions = Json::encode($this->permissions);
		}
		return parent::beforeSave($insert);
	}

	public static function is_backend_login_array() {
		return [
			Module::hasMultiLanguage() ? RoleHelper::translate('no') : 'Không',
			Module::hasMultiLanguage() ? RoleHelper::translate('yes') : 'Có',
		];
	}
}
