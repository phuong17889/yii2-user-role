<?php
/* @var $this yii\web\View */
use navatech\role\helpers\RoleHelper;

/* @var $model navatech\role\models\Role */
$this->title                   = RoleHelper::isMultiLanguage() ? RoleHelper::translate('update') : 'Cập nhật' . ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = [
	'label' => RoleHelper::isMultiLanguage() ? RoleHelper::translate('user_role') : 'Nhóm thành viên',
	'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
	'label' => $model->name,
	'url'   => [
		'view',
		'id' => $model->id,
	],
];
$this->params['breadcrumbs'][] = RoleHelper::isMultiLanguage() ? RoleHelper::translate('update') : 'Cập nhật';
?>
<div class="role-update">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
