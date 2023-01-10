<?php
/**
 * Created by phuongdev89.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuongdev89@gmail.com
 * @date    27/02/2016
 * @time    12:15 SA
 */

namespace phuongdev89\role\models\forms;

use phuongdev89\base\Module;
use phuongdev89\role\helpers\RoleHelper;
use phuongdev89\role\models\Role;
use phuongdev89\role\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class LoginForm extends \dektrium\user\models\LoginForm
{

    /**@var $user User */
    protected $user;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        $rules = parent::rules();
        return ArrayHelper::merge($rules, [
            'backendLoginValidate' => [
                'login',
                function ($attribute) {
                    if ($this->user !== null && $this->user->getRole()->exists() && $role = $this->user->getRole()->one()) {
                        /** @var $role Role */
                        if ($role->is_backend_login == 0) {
                            if (Module::hasMultiLanguage()) {
                                $this->addError($attribute, RoleHelper::translate('invalid_login_or_password'));
                            } else {
                                $this->addError($attribute, Yii::t('role', 'Invalid login or password'));
                            }
                        }
                    }
                },
            ],
        ]);
    }
}
