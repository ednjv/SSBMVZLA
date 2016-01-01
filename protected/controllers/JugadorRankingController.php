<?php

class JugadorRankingController extends Controller
{

/**
 * @var string the default action for the controller.
 */
public $defaultAction = 'admin';

/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
public $layout='//layouts/column1';

public $pageTitle='SSBM Venezuela - Ranking';

/**
* @return array action filters
*/
public function filters()
{
return array(
'accessControl', // perform access control for CRUD operations
);
}

public function accessRules()
{
return array(
array('allow',
	'actions'=>array('update','delete','index','create'),
	'users'=>array('Administrador'),
),
array('allow',
	'actions'=>array('view','admin','GetChart'),
	'users'=>array('*'),
),
array('deny',
	'users'=>array('*'),
),
);
}


/**
* Displays a particular model.
* @param integer $id the ID of the model to be displayed
*/
public function actionView($id)
{
$this->render('view',array(
'model'=>$this->loadModel($id),
));
}

/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
$model=new JugadorRanking;
$user = Yii::app()->user;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['JugadorRanking']))
{
$model->attributes=$_POST['JugadorRanking'];
if($model->save()){
	$user->setFlash('success', "Datos han sido guardados <strong>satisfactoriamente</strong>.");
	$this->redirect(array('admin'));
}
}

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
$model=$this->loadModel($id);
$user = Yii::app()->user;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['JugadorRanking']))
{
$model->attributes=$_POST['JugadorRanking'];
if($model->save()){
			$user->setFlash('success', "Datos han sido modificados <strong>satisfactoriamente</strong>.");
			$this->redirect(array('admin'));
		}
}

$this->render('update',array(
'model'=>$model,
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
* Lists all models.
*/
public function actionIndex()
{
$dataProvider=new CActiveDataProvider('JugadorRanking');
$this->render('index',array(
'dataProvider'=>$dataProvider,
));
}

/**
* Manages all models.
*/
public function actionAdmin()
{
$lastUpdate=strftime("%d/%m/%Y",strtotime(str_replace("-", "/", JugadorRanking::model()->find('status=1')->fecha)));
$selectPersonajes=Personaje::model()->selectPersonajes();
$model=new JugadorRanking('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['JugadorRanking']))
$model->attributes=$_GET['JugadorRanking'];

$this->render('admin',array(
'model'=>$model,
'lastUpdate'=>$lastUpdate,
'selectPersonajes'=>$selectPersonajes,
));
}

/**
* Returns the data model based on the primary key given in the GET variable.
* If the data model is not found, an HTTP exception will be raised.
* @param integer the ID of the model to be loaded
*/
public function loadModel($id)
{
$model=JugadorRanking::model()->findByPk($id);
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
if(isset($_POST['ajax']) && $_POST['ajax']==='jugador-ranking-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}

public function actionGetChart(){
	$id=$_POST['id'];
	if($id!=""){
		$rankJugId=JugadorRanking::model()->findByPk($id);
		$jugador=Jugador::model()->findByPk($rankJugId->id_jugador);
		$sets=PvpSet::model()->chartSets($rankJugId->id_jugador);
		$vsJugador=PvpSet::model()->chartVsJugadores($sets,$jugador->id);
		$ptsVs=PvpSet::model()->chartPtsVs($sets,$jugador->id);
		$this->renderPartial('_chartJug',array(
			'sets'=>$sets,
			'jugador'=>$jugador,
			'vsJugador'=>$vsJugador,
			'ptsVs'=>$ptsVs,
		),false,true);
	}
}
}
