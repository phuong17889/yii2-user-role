<?php
/**
 * Created by phuong17889.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    26/02/2016
 * @time    6:05 CH
 */

namespace phuong17889\role\helpers;

use phuong17889\role\models\Role;
use phuong17889\role\models\User;
use Yii;
use yii\helpers\Json;

class RoleChecker
{

    /**
     * @param        $controller
     * @param mixed $action
     * @param null $role_id
     *
     * @return bool
     */
    public static function isAuth($controller, $action = null, $role_id = null)
    {
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
                $valid = false;
                if ($action != null) {
                    foreach ($permissions as $controllerName => $actions) {
                        if ($controllerName != $controller) {
                            continue;
                        } else {
                            if (!is_array($action)) {
                                $action = [$action];
                            }
                            foreach ($action as $item) {
                                if (in_array($item, array_keys($actions))) {
                                    if (($actions[$item] == 1)) {
                                        $valid = true;
                                        break;
                                    }
                                } else {
                                    $valid = true;
                                    break;
                                }
                            }
                        }
                    }
                } else {
                    foreach ($permissions as $controllerName => $actions) {
                        if ($controllerName != $controller) {
                            continue;
                        } else {
                            foreach ($actions as $item) {
                                if ($item == 1) {
                                    $valid = true;
                                    break;
                                }
                            }
                        }
                    }
                }
                return $valid;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}
