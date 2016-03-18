<?php
/**
 * Created by Navatech.
 * @project attravel
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    27/02/2016
 * @time    12:12 SA
 */
namespace navatech\role\models;

use yii\db\ActiveQuery;

/**
 * @property $role_id int
 */
class User extends \dektrium\user\models\User {

	/**
	 * @return ActiveQuery
	 */
	public function getRole() {
		return $this->hasOne(Role::className(), ['id' => 'role_id']);
	}

	/**
	 * @return int
	 */
	public function getRoleId() {
		return $this->role_id;
	}
}
