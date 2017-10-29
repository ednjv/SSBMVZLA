<?php
class UserController extends Controller
{
	/**
	 * @var string the default action for the controller.
	 */
	public $defaultAction = 'admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
			);
	}

	public function actions()
	{
		return array(
			'toggle' => array(
				'class'=>'booster.actions.TbToggleAction',
				'modelName' => 'User',
				)
			);
	}

        /**
         * Returns all recent unread notifications
         *
         */
        public function actionGetNotifications(){
        	$model = new Notification;
        	$array= array();
        	$notifications = $model->findAll(
        		array(
        			'order'=>'dateTime DESC',
        			'condition'=>'receiver=:_r AND status=:_s',
        			'limit'=>5,
        			'params'=>array(
        				':_r'=>Yii::app()->user->getName(),
        				':_s'=>0
        				),
        			)
        		);
        	foreach ($notifications as $value) {
        		$array[]= array(
        			'id'=>$value['id'],
        			'sender'=>$value['sender'],
        			'receiver'=>$value['receiver'],
        			'message'=>$value['message'],
        			'link'=>$value['link'],
        			'dateTime'=>$value['dateTime'],
        			'status'=>$value['status']
        			);
        	}
        	if(count($array)>0){
        		echo json_encode($array);
        	}else{
        		echo false;
        	}
        }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$user = Yii::app()->getUser();
		if ($user->checkAccess('Admin')){  $user= $id; } else { $user= Yii::app()->user->id;}

		$this->render('view',array(
			'model'=>$this->loadModel($user),
			));
	}

	public function actionFlashCard()
	{

		$this->render('_flashCard',array());
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if ($model->saveUsuario($_POST['User']))

			$this->redirect(array('view','id'=>$model->id));

		$this->render('create',array(
			'model'=>$model,
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$user = Yii::app()->getUser();
		if ($user->checkAccess('Admin')){  $user= $id; } else { $user= Yii::app()->user->id;}

		$model=$this->loadModel($user);

                // Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if ($model->saveUsuario($_POST['User']))
			$this->redirect(array('view','id'=>$user));

		$this->render('update',array(
			'model'=>$model,
			));
	}

	public function actionUpdatePassword($id)
	{
		$user = Yii::app()->getUser();
		if ($user->checkAccess('Admin')){  $user= $id; } else { $user= Yii::app()->user->id;}


		$model = new UserUpdatePassword;


		if ($model->UpdatePassword($_POST['UserUpdatePassword'],$user))
			$this->redirect(array('view','id'=>$user));

		$this->render('updatePassword',array(
			'model'=>$model,
			'user_id'=>$user,
			));
	}

	public function actionActualizarStatus()
	{
		if($_POST['id']!=1){
			$model = new User;
			if ($model->updateByPk($_POST['id'], array('status'=>$_POST['status'])))
			{
				echo 'El usuario ahora está '.$model->itemAlias("UserStatus",$_POST['status']);
			} else {
				echo 'Ha ocurrido un error';
			}
		} else {
			echo 'Usuario Administrador';
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->redirect(array('view','id'=>Yii::app()->user->id));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
