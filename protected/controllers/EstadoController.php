<?php

class EstadoController extends Controller
{

	/**
	 * @var string the default action for the controller.
	 */
	public $defaultAction='admin';

	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column1';

	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
			'postOnly + delete' // we only allow deletion via POST request
		);
	}

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
		$model=new Estado;
		$user=Yii::app()->user;
		$selectPaises=Pais::model()->selectPaises();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Estado']))
		{
			$model->attributes=$_POST['Estado'];
			if($model->save())
			{
				$user->setFlash('success', "Datos han sido guardados <strong>satisfactoriamente</strong>.");
				$this->redirect(array('create'));
			}
		}

		$this->render('create', array(
			'model'=>$model,
			'selectPaises'=>$selectPaises
		));
	}

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$user=Yii::app()->user;
		$selectPaises=Pais::model()->selectPaises();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Estado']))
		{
			$model->attributes=$_POST['Estado'];
			if($model->save()){
				$user->setFlash('success', "Datos han sido modificados <strong>satisfactoriamente</strong>.");
				$this->redirect(array('admin'));
			}
		}

		$this->render('update', array(
			'model'=>$model,
			'selectPaises'=>$selectPaises
		));
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new Estado('search');
		$model->unsetAttributes();  // clear any default values
		$selectPaises=Pais::model()->selectPaises();
		if(isset($_GET['Estado']))
			$model->attributes=$_GET['Estado'];

		$this->render('admin', array(
			'model'=>$model,
			'selectPaises'=>$selectPaises
		));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($id)
	{
		$model=Estado::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='estado-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}