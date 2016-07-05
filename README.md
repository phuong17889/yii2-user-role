# yii2-user-role
Install
---
~~~
composer require navatech/yii2-user-role "@dev"
~~~
### Run migrate
if you're never used `dektrium/yii2-user` before, you should run it
~~~
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
~~~
~~~
php yii migrate/up --migrationPath=@navatech/role/migrations
~~~
Config:
---
## in config file
~~~
[php]
'modules'    => [
    'user'  => [
        'class'              => 'dektrium\user\Module',
        'modelMap'           => [
            'User'      => 'navatech\role\models\User',//IMPORTANT & REQUIRED, change to your User model if overridden
            'LoginForm' => 'navatech\role\models\LoginForm',//IMPORTANT & REQUIRED
        ],
    ],
   'role'  => [
        'class'               => 'navatech\role\Module',
        'controllers'         => [ //namespaces of controllers
            'app\controllers',
            'navatech\role\controllers',
        ],
    ],
],
~~~

## in model User, if you override it
~~~
class User extends \navatech\role\models\User
~~~

## In every controller you want to check role
~~~
class SiteController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
            ....
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
~~~
