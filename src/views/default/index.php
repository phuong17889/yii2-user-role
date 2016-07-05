<?php
use navatech\base\Module;
use navatech\role\helpers\RoleHelper;
use navatech\role\models\Role;
use navatech\role\models\RoleSearch;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchModel RoleSearch */
/* @var $dataProvider ActiveDataProvider */
$this->title                   = Module::hasMultiLanguage() ? RoleHelper::translate('user_role') : Yii::t('role', 'User role');
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
	<?= Html::a(Module::hasMultiLanguage() ? RoleHelper::translate('create') : Yii::t('role', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
</p>
<div class="role-index">

	<?php Pjax::begin(); ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'columns'      => [
			'id',
			'name',
			[
				'attribute' => 'is_backend_login',
				'filter'    => $searchModel->is_backend_login_array(),
				'value'     => function(Role $model) {
					$values = $model->is_backend_login_array();
					return $values[$model->is_backend_login];
				},
			],
			[
				'class'    => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}',
			],
		],
	]); ?>
	<?php Pjax::end(); ?>
</div>
