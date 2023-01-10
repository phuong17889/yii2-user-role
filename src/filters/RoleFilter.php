<?php
/**
 * Created by phuongdev89.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuongdev89@gmail.com
 * @date    26/02/2016
 * @time    2:05 CH
 */

namespace phuongdev89\role\filters;

use phuongdev89\base\Module;
use phuongdev89\role\helpers\RoleChecker;
use phuongdev89\role\helpers\RoleHelper;
use Yii;
use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class RoleFilter extends Behavior
{

    public $actions = [];

    public $name = '';

    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array events (array keys) and the corresponding event handler methods (array values).
     */
    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction'];
    }

    /**
     * @param ActionEvent $event
     * @return bool|void
     * @throws ForbiddenHttpException
     */
    public function beforeAction(ActionEvent $event)
    {
        $controller = $event->action->controller;
        $controllerClass = get_class($controller);
        $action = $event->action->id;
        if (RoleChecker::isAuth($controllerClass, $action)) {
            return true;
        } else {
            if (Yii::$app->user->isGuest) {
                Yii::$app->user->loginRequired();
            } else if (Module::hasMultiLanguage()) {
                throw new ForbiddenHttpException(RoleHelper::translate('forbidden'), 403);
            } else {
                throw new ForbiddenHttpException(Yii::t('role', 'You are not allowed to perform this action.'), 403);
            }
        }
    }
}
