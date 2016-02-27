<?php
/**
 * Created by Navatech.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    26/02/2016
 * @time    6:05 CH
 */
namespace navatech\role\helpers;

use navatech\role\models\Role;
use Yii;
use yii\helpers\Json;

class RoleChecker {

	/**
	 * @param        $controller
	 * @param string $action
	 * @param null   $role_id
	 *
	 * @return bool
	 */
	public static function isAuth($controller, $action = '', $role_id = null) {
		if (Yii::$app->user->isGuest) {
			return false;
		}
		if ($role_id != null) {
			/**@var $role Role */
			$role = Role::findOne(['id' => $role_id]);
		} else {
			/**@var $role Role */
			$role = Yii::$app->user->identity->getRole();
		}
		if ($role === null) {
			return false;
		}
		$permissions = Json::decode($role->permissions);
		if ($permissions != null && in_array($controller, array_keys($permissions))) {
			if ($action == '') {
				return true;
			} else {
				foreach (Json::decode($role->permissions) as $controllerName => $actions) {
					if ($controllerName != $controller) {
						continue;
					} else {
						if (in_array($action, array_keys($actions))) {
							return ($actions[$action] == 1);
						} else {
							return true;
						}
					}
				}
				return false;
			}
		} else {
			return false;
		}
	}
}