<?php
use navatech\role\helpers\RoleChecker;
use navatech\role\helpers\RoleHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model navatech\role\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
	input[type=checkbox].ace + .lbl::before, input[type=radio].ace + .lbl::before {
		margin-right: 5px !important;
	}
</style>
<div class="col-sm-12">
	<div class="role-form">
		<?php $form = ActiveForm::begin([
			'options' => [
				'class' => 'form-horizontal',
				'role'  => 'form',
			],
		]); ?>
		<?php echo $form->field($model, 'name', [
			'template'     => '{label}<div class="col-sm-12">{input}{error}</div>',
			'labelOptions' => ['class' => 'control-label'],
		])->textInput(['class' => 'col-sm-5']); ?>

		<?= $form->field($model, 'is_backend_login', [
			'template'     => '{label}<div class="col-sm-12">{input}{error}</div>',
			'labelOptions' => ['class' => 'control-label'],
		])->dropDownList([
			'No',
			'Yes',
		], ['class' => 'col-sm-1']) ?>
		<hr>
		<div class="form-group">
			<?= Html::activeLabel($model, 'permissions') ?>
			<?php foreach (RoleHelper::getControllers() as $controller) : ?>
				<?php $actions = RoleHelper::getActions($controller); ?>
				<?php if ($actions != null) : ?>
					<div class="row well">
						<?= Html::label($actions['name'], null, ['style' => 'font-weight:bold;']) ?>
						<div class="col-sm-12">
							<?php foreach ($actions['actions'] as $action => $name) : ?>
								<div class="checkbox col-sm-2">
									<?= Html::hiddenInput('Role[permissions][' . $controller . '][' . $action . ']', 0) ?>
									<?= Html::checkbox('Role[permissions][' . $controller . '][' . $action . ']', RoleChecker::isAuth($controller, $action), [
										'class' => 'ace',
										'id'    => 'Role_permissions_' . str_replace('\\', '_', $controller) . '_' . $action,
									]) ?>
									<?= Html::label($name, 'Role_permissions_' . str_replace('\\', '_', $controller) . '_' . $action, ['class' => 'lbl']) ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? (RoleHelper::isMultiLanguage() ? RoleHelper::translate('create') : 'Thêm mới') : (RoleHelper::isMultiLanguage() ? RoleHelper::translate('update') : 'Cập nhật'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>