<?php
/**
 * Created by Navatech.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    26/02/2016
 * @time    5:34 CH
 */
namespace navatech\role\interfaces;

use navatech\role\models\Role;

interface UserInterface {

	/**
	 * Example:
	 * return $this->hasOne(\navatech\role\models\Role::className(), ['id'=>'role_id'])->one();
	 * Important: must return one();
	 * @return Role
	 */
	public function getRole();

	/**
	 * Example:
	 * return $this->role_id;
	 * @return int
	 */
	public function getRoleId();
}