<?php
namespace navatech\role\controllers;

use navatech\base\Module;
use navatech\role\filters\RoleFilter;
use navatech\role\helpers\RoleHelper;
use navatech\role\models\Role;
use navatech\role\models\RoleSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DefaultController implements the CRUD actions for Role model.
 */
class DefaultController extends Controller {

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'verbs' => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
			'role'  => [
				'class'   => RoleFilter::className(),
				'name'    => Module::hasMultiLanguage() ? RoleHelper::translate('role') : 'Phân quyền',
				'actions' => [
					'index'  => Module::hasMultiLanguage() ? RoleHelper::translate('index') : 'Danh sách',
					'create' => Module::hasMultiLanguage() ? RoleHelper::translate('create') : 'Thêm mới',
					'update' => Module::hasMultiLanguage() ? RoleHelper::translate('update') : 'Cập nhật',
					'delete' => Module::hasMultiLanguage() ? RoleHelper::translate('delete') : 'Xóa',
					'view'   => Module::hasMultiLanguage() ? RoleHelper::translate('view') : 'Chi tiết',
				],
			],
		];
	}

	/**
	 * Lists all Role models.
	 * @return mixed
	 */
	public function actionIndex() {
		$searchModel  = new RoleSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->render('index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Creates a new Role model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new Role();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect([
				'update',
				'id' => $model->id,
			]);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Role model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect([
				'update',
				'id' => $model->id,
			]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Role model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
		return $this->redirect(['index']);
	}

	/**
	 * Finds the Role model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 *
	 * @param integer $id
	 *
	 * @return Role the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Role::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
