<?php
/* @var $this yii\web\View */

use phuong17889\base\Module;
use phuong17889\role\helpers\RoleHelper;
use yii\bootstrap\Html;

/* @var $model phuong17889\role\models\Role */
$this->title = Module::hasMultiLanguage() ? RoleHelper::translate('create') : Yii::t('role', 'Create');
$this->params['breadcrumbs'][] = [
    'label' => Module::hasMultiLanguage() ? RoleHelper::translate('user_role') : Yii::t('role', 'User role'),
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
