<?php
/**
 * Created by Navatech.
 * @project attravel
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    27/02/2016
 * @time    12:15 SA
 */
namespace navatech\role\models;

use navatech\role\helpers\RoleHelper;
use Yii;
use yii\helpers\ArrayHelper;

class LoginForm extends \dektrium\user\models\LoginForm {

	/**@var $user User */
	protected $user;

	/**
	 * {@inheritDoc}
	 */
	public function rules() {
		$rules = parent::rules();
		return ArrayHelper::merge($rules, [
			'backendLoginValidate' => [
				'login',
				function($attribute) {
					if ($this->user !== null) {
						if ($this->user->getRole()->is_backend_login == 0) {
							if (RoleHelper::isMultiLanguage()) {
								$this->addError($attribute, RoleHelper::translate('invalid_login_or_password'));
							} else {
								$this->addError($attribute, Yii::t('user', 'Invalid login or password'));
							}
						}
					}
				},
			],
		]);
	}
}