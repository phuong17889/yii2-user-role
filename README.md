# yii2-user-role

Install
---

~~~
composer require phuongdev89/yii2-user-role "@dev"
~~~

Configuration
---
### in `backend/config/main.php` or `app/config/web.php`
~~~
[php]
'modules' => [
    'user' => [
        'class' => 'dektrium\user\Module',
        'modelMap' => [
            'User' => 'phuongdev89\role\models\User',//IMPORTANT & REQUIRED, change to your User model if overridden
            'LoginForm' => 'phuongdev89\role\models\LoginForm',//IMPORTANT & REQUIRED, change to your User model if overridden
        ],
    ],
   'role' => [
        'class' => 'phuongdev89\role\Module',
        'controllers' => [ 
            //namespaces of controllers you want to control
            'app\controllers',
            'phuongdev89\role\controllers',
        ],
    ],
],
~~~

### in `console/config/main.php` or `app/config/console.php`
~~~
'controllerMap' => [
    ...
    'migrate'  => [
        'class' => 'yii\console\controllers\MigrateController',
        'migrationPath' => [
            '@console/migrations',
            '@vendor/dektrium/yii2-user/migrations',
            '@phuongdev89/role/migrations',
        ],
    ],
],
~~~

### Run migrate
~~~
php yii migrate/up
~~~

Usage
---

### in model User, if you override it
~~~
class User extends \phuongdev89\role\models\User
~~~

### In every controller you want to check role
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
### In everywhere:

~~~
use phuongdev89\role\helpers\RoleChecker;
...
//public static function isAuth($controller, $action = '', $role_id = null)
$boolean = RoleChecker::isAuth(SiteController::className(), 'index', Yii::$app->user->identity->getRoleId());
~~~
