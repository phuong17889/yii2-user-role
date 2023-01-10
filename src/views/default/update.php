<?php

use phuongdev89\base\Module;
use phuongdev89\role\helpers\RoleHelper;
use phuongdev89\role\models\Role;
use yii\bootstrap\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Role $model
 */
$this->title = Module::hasMultiLanguage() ? RoleHelper::translate('update') . ' ' . $model->name : Yii::t('role', 'Update: {0}', $model->name);
$this->params['breadcrumbs'][] = [
    'label' => Module::hasMultiLanguage() ? RoleHelper::translate('user_role') : Yii::t('role', 'User role'),
    'url' => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        'view',
        'id' => $model->id,
    ],
];
$this->params['breadcrumbs'][] = Module::hasMultiLanguage() ? RoleHelper::translate('update') : Yii::t('role', 'Update');
?>
<div class="role-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
