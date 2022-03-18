<?php
/**
 * Created by phuong17889.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    27/02/2016
 * @time    12:12 SA
 */

namespace phuong17889\role\models;

use yii\db\ActiveQuery;

/**
 * @property-read int $roleId
 * @property-read Role $role
 * @property $role_id int
 */
class User extends \dektrium\user\models\User
{

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [
            ['role_id'],
            'integer',
        ];
        return $rules;
    }

    /**
     * @return ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->role_id;
    }
}
