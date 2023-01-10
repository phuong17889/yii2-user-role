<?php
/**
 * Created by phuongdev89.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuongdev89@gmail.com
 * @date    27/02/2016
 * @time    12:15 SA
 */

namespace phuongdev89\role\models;

use phuongdev89\base\Module;
use phuongdev89\role\helpers\RoleHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "role".
 *
 * @property integer $id
 * @property string $name
 * @property string $permissions
 * @property integer $is_backend_login
 */
class Role extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    public static function is_backend_login_array()
    {
        return [
            Module::hasMultiLanguage() ? RoleHelper::translate('no') : Yii::t('role', 'No'),
            Module::hasMultiLanguage() ? RoleHelper::translate('yes') : Yii::t('role', 'Yes'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Module::hasMultiLanguage() ? RoleHelper::translate('user_role') : Yii::t('role', 'User role'),
            'permissions' => Module::hasMultiLanguage() ? RoleHelper::translate('permission') : Yii::t('role', 'Permission'),
            'is_backend_login' => Module::hasMultiLanguage() ? RoleHelper::translate('is_backend_login') : Yii::t('role', 'Backend login'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function beforeSave($insert)
    {
        if (is_array($this->permissions)) {
            $this->permissions = Json::encode($this->permissions);
        }
        return parent::beforeSave($insert);
    }
}
