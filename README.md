# yii2-user-role
Config:
---
## in config file
~~~
[php]
'modules'    => [
    'role'  => [
        'class'               => 'navatech\role\Module',
        'controllers'         => [ //namespaces of controllers
            'app\controllers',
            'navatech\role\controllers',
        ],
    ],
],
~~~

## in model User
### Way 1: open model User and implements UserInterface
~~~
class User extends \yii\db\ActiveRecord implements \navatech\role\interfaces\UserInterface
~~~
### or Way 2: add two methods without implements UserInterface
~~~
	/**
	 * {@inheritDoc}
	 */
	public function getRole() {
		return $this->hasOne(Role::className(), ['id' => 'role_id'])->one();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getRoleId() {
		return $this->role_id;
	}

~~~

## In every controller you want to check role
~~~
class SiteController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete'        => ['post'],
                ],
            ],
            'role'  => [
                'class'   => RoleFilter::className(),
                'name'    => 'Trang chủ', //NOT REQUIRED, only if you want to translate
                'actions' => [
                    'create', //without translate
                    'index' => 'Danh sách', //with translated, which will display on role _form
                ],
            ],
        ];
    }
}
~~~

## In everywhere:
~~~
use navatech\role\helpers\RoleChecker;
...
//public static function isAuth($controller, $action = '', $role_id = null)
$boolean = RoleChecker::isAuth(SiteController::className(), 'index', Yii::$app->user->identity->getRoleId());

//public static function hasActive($controller, $action = '', $role_id = null)
$active = RoleChecker::hasActive(SiteController::className(), 'index', Yii::$app->user->identity->getRoleId());

<div class="<?=$active?>"></div>
~~~