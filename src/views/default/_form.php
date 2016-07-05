<?php
use navatech\base\Module;
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
			<?php foreach (RoleHelper::getControllers() as $id => $controller) : ?>
				<?php $actions = RoleHelper::getActions($controller); ?>
				<?php if ($actions != null) : ?>
					<div class="row well">
						<?= Html::checkbox('checkall', false, [
							'class' => 'ace',
							'id'    => $id,
							'title' => Yii::t('role', 'Toggle all'),
						]) ?>
						<?= Html::label($actions['name'], $id, [
							'style' => 'font-weight:bold;',
							'class' => 'lbl',
						]) ?>
						<div class="col-sm-12 checkbox-list">
							<?php foreach ($actions['actions'] as $action => $name) : ?>
								<div class="checkbox col-sm-2">
									<?= Html::hiddenInput('Role[permissions][' . $controller . '][' . $action . ']', 0) ?>
									<?= Html::checkbox('Role[permissions][' . $controller . '][' . $action . ']', RoleChecker::isAuth($controller, $action, $model->id), [
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
			<?= Html::submitButton($model->isNewRecord ? (Module::hasMultiLanguage() ? RoleHelper::translate('create') : Yii::t('role', 'Create')) : (Module::hasMultiLanguage() ? RoleHelper::translate('update') : Yii::t('role', 'Update')), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<script>
	$(document).on("click", "input[name='checkall']", function() {
		var th = $(this);
		if(th.is(":checked")) {
			th.closest(".row").find(".checkbox-list").find("input[type='checkbox']").prop("checked", true);
		} else {
			th.closest(".row").find(".checkbox-list").find("input[type='checkbox']").prop("checked", false);
		}
	});
</script>