<?php
/**
 * Created by Navatech.
 * @project yii2-user-role
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    26/02/2016
 * @time    11:50 PM
 */
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
				'name'    => Module::hasMultiLanguage() ? RoleHelper::translate('role') : Yii::t('role', 'Role'),
				'actions' => [
					'index'  => Module::hasMultiLanguage() ? RoleHelper::translate('index') : Yii::t('role', 'List'),
					'create' => Module::hasMultiLanguage() ? RoleHelper::translate('create') : Yii::t('role', 'Create'),
					'update' => Module::hasMultiLanguage() ? RoleHelper::translate('update') : Yii::t('role', 'Update'),
					'delete' => Module::hasMultiLanguage() ? RoleHelper::translate('delete') : Yii::t('role', 'Delete'),
					'view'   => Module::hasMultiLanguage() ? RoleHelper::translate('view') : Yii::t('role', 'View'),
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
}
