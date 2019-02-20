<?php
/**
 * Created by Navatech.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    26/02/2016
 * @time    2:40 CH
 */

namespace navatech\role\helpers;

use navatech\role\filters\RoleFilter;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionMethod;
use RegexIterator;
use UnexpectedValueException;
use Yii;
use yii\base\ErrorException;
use yii\base\Module;
use yii\helpers\ArrayHelper;

class RoleHelper extends ArrayHelper {

	/**
	 * @param null $paths
	 *
	 * @return array
	 * @throws ErrorException
	 */
	public static function getControllers($paths = null) {
		if ($paths === null) {
			$paths = Yii::$app->controller->module->controllers;
		}
		if (!is_array($paths)) {
			$paths = [$paths];
		}
		$namespaces = [];
		foreach ($paths as $path) {
			$path  = Yii::getAlias('@' . str_replace('\\', '/', $path));
			$fqcns = array();
			try {
				$allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
				$phpFiles = new RegexIterator($allFiles, '/\.php$/');
				foreach ($phpFiles as $phpFile) {
					$content   = file_get_contents($phpFile->getRealPath());
					$tokens    = token_get_all($content);
					$namespace = '';
					for ($index = 0; isset($tokens[$index]); $index ++) {
						if (!isset($tokens[$index][0])) {
							continue;
						}
						if (T_NAMESPACE === $tokens[$index][0]) {
							$index += 2;
							while (isset($tokens[$index]) && is_array($tokens[$index])) {
								$namespace .= $tokens[$index ++][1];
							}
						}
						if (T_CLASS === $tokens[$index][0]) {
							$index += 2;
							if (isset($tokens[$index][1]) && strpos($tokens[$index][1], 'Controller') !== false) {
								$fqcns[] = $namespace . '\\' . $tokens[$index][1];
							}
						}
					}
				}
				$namespaces = ArrayHelper::merge($namespaces, $fqcns);
			} catch (UnexpectedValueException $e) {
				throw new ErrorException(Yii::t('role', 'Wrong configure. Please recheck role\'s controllers path in your config file. (app-id/config/web|main.php)'), 2, 1, __DIR__ . '/RoleHelper.php', 70, $e);
			}
		}
		return array_unique($namespaces);
	}

	/**
	 * @param $namespaces
	 *
	 * @return array
	 */
	public static function getActions($namespaces) {
		error_reporting(0);
		if (!is_array($namespaces)) {
			$namespaces = [$namespaces];
		}
		$response = [];
		foreach ($namespaces as $namespace) {
			$class     = new ReflectionClass($namespace);
			$methods   = $class->getMethods(ReflectionMethod::IS_PUBLIC);
			$behaviors = call_user_func([
				$namespace,
				'behaviors',
			]);
			foreach ($methods as $method) {
				if ($method->class === $namespace && strpos($method->name, 'action') === 0) {
					if (isset($behaviors['role']) && $behaviors['role']['class'] === RoleFilter::className()) {
						$actions = [];
						foreach ($behaviors['role']['actions'] as $key => $action) {
							if (is_int($key)) {
								$actions[$action] = Yii::t('app', ucfirst($action));
							} else {
								$actions[$key] = $action;
							}
						}
						$response['name']    = isset($behaviors['role']['name']) ? $behaviors['role']['name'] : end(explode('\\', $namespace));
						$response['actions'] = $actions;
						break;
					}
				}
			}
		}
		return $response;
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public static function translate($name) {
		return \navatech\language\Translate::$name();
	}
}
