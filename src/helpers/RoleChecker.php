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
use navatech\role\models\User;
use Yii;
use yii\helpers\Json;

class RoleChecker {

	/**
	 * @param        $controller
	 * @param mixed $action
	 * @param null   $role_id
	 *
	 * @return bool
	 */
	public static function isAuth($controller, $action = null, $role_id = null) {
		if (Yii::$app->user->isGuest) {
			return false;
		}
		if ($role_id != null) {
			/**@var $role Role */
			$role = Role::findOne(['id' => $role_id]);
		} else {
			/**@var $user User */
			$user = Yii::$app->user->identity;
			if ($user->getRole()->exists()) {
				/**@var $role Role */
				$role = $user->getRole()->one();
			} else {
				$role = new Role();
			}
		}
		if ($role === null) {
			return false;
		}
		if ($role->is_backend_login != 1) {
			return false;
		}
		$permissions = Json::decode($role->permissions);
		if ($permissions != null) {
			if (in_array($controller, array_keys($permissions))) {
				if ($action == null) {
					return true;
				} else {
					foreach (Json::decode($role->permissions) as $controllerName => $actions) {
						if ($controllerName != $controller) {
							continue;
						} else {
							if(!is_array($action)){
								$action = [$action];
							}
							foreach ($action as $item) {
								if (in_array($item, array_keys($actions))) {
									return ($actions[$item] == 1);
								}
							}
							return true;
						}
					}
					return false;
				}
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
}
