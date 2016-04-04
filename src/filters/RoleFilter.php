<?php
/**
 * Created by Navatech.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    26/02/2016
 * @time    2:05 CH
 */
namespace navatech\role\filters;

use navatech\role\helpers\RoleChecker;
use navatech\role\helpers\RoleHelper;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class RoleFilter extends Behavior {

	public        $actions = [];

	public        $name    = '';

	public static $a;

	/**
	 * Declares event handlers for the [[owner]]'s events.
	 * @return array events (array keys) and the corresponding event handler methods (array values).
	 */
	public function events() {
		return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
	}

	public function beforeAction(ActionEvent $event) {
		$controller = $event->action->controller->className();
		$action     = $event->action->id;
		if (RoleChecker::isAuth($controller, $action)) {
			return true;
		} else {
			if (RoleHelper::isMultiLanguage()) {
				throw new ForbiddenHttpException(RoleHelper::translate('forbidden'), 403);
			} else {
				throw new ForbiddenHttpException('Bạn không được phép truy cập!', 403);
			}
		}
	}
}
