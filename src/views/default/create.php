<?php
/* @var $this yii\web\View */
use navatech\role\helpers\RoleHelper;

/* @var $model navatech\role\models\Role */
$this->title                   = RoleHelper::isMultiLanguage() ? RoleHelper::translate('create') : 'Thêm mới';
$this->params['breadcrumbs'][] = [
	'label' => RoleHelper::isMultiLanguage() ? RoleHelper::translate('user_role') : 'Nhóm thành viên',
	'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
