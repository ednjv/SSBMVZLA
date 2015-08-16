<?php

set_time_limit(900);

class PvpSetController extends Controller
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

/**
* @return array action filters
*/
public function filters()
{
return array(
'rights', // perform access control for CRUD operations
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
$model=new PvpSet;
$user = Yii::app()->user;
$selectJugadores=Jugador::model()->selectJugadores();
$selectTorneos=Torneo::model()->selectTorneos();
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['PvpSet']))
{
$model->attributes=$_POST['PvpSet'];
$model->elo_jugador_1=0;
$model->elo_jugador_2=0;
if($model->save()){
	$user->setFlash('success', "Datos han sido guardados <strong>satisfactoriamente</strong>.");
	$this->redirect(array('create'));
}
}

$this->render('create',array(
'model'=>$model,
'selectJugadores'=>$selectJugadores,
'selectTorneos'=>$selectTorneos,
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
$selectJugadores=Jugador::model()->selectJugadores();
$selectTorneos=Torneo::model()->selectTorneos();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['PvpSet']))
{
$model->attributes=$_POST['PvpSet'];
if($model->save()){
	$user->setFlash('success', "Datos han sido modificados <strong>satisfactoriamente</strong>.");
	$this->redirect(array('admin'));
}
}

$this->render('update',array(
'model'=>$model,
'selectJugadores'=>$selectJugadores,
'selectTorneos'=>$selectTorneos,
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
$dataProvider=new CActiveDataProvider('PvpSet');
$this->render('index',array(
'dataProvider'=>$dataProvider,
));
}

/**
* Manages all models.
*/
public function actionAdmin()
{
$model=new PvpSet('search');
$model->unsetAttributes();  // clear any default values
if(isset($_GET['PvpSet']))
$model->attributes=$_GET['PvpSet'];

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
$model=PvpSet::model()->findByPk($id);
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
if(isset($_POST['ajax']) && $_POST['ajax']==='pvp-set-form')
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
		$sets=PvpSet::model()->findAll(array(
			'condition'=>'(id_jugador_1=:idJug OR id_jugador_2=:idJug) AND (elo_jugador_1>0 OR elo_jugador_2>0)',
			'params'=>array(':idJug'=>$rankJugId->id_jugador),
			'order'=>'numero_ronda',
		));
		return $this->renderPartial('_chartJug',array(
			'sets'=>$sets,
			'jugador'=>$jugador,
		),false,true);
	}
}

public function actionElo($id){
	$user=Yii::app()->user;
	$busq=PvpSet::model()->findAll(array(
		'condition'=>'id_torneo=:id_torneo',
		'params'=>array(':id_torneo'=>$id),
		'order'=>'numero_ronda',
	));
	foreach ($busq as $pvpset) {
		PvpSet::model()->calcularRanking($pvpset);
	}
	JugadorRankTemp::model()->calcularPosiciones();
	$user->setFlash('success', "Datos han sido modificados <strong>satisfactoriamente</strong>.");
	$this->redirect(array('admin'));
}

public function actionImportRank(){
	$user=Yii::app()->user;
	$busqRankTemp=JugadorRankTemp::model()->findAll(array(
		'condition'=>'status=1',
	));
	foreach ($busqRankTemp as $rnkTmp) {
		$newRank=new JugadorRanking;
		$newRank->id_jugador=$rnkTmp->id_jugador;
		$newRank->puntos=$rnkTmp->puntos;
		$newRank->fecha=date("Y-m-d h:i:s");
		$newRank->status=$rnkTmp->status;
		$newRank->posicion=$rnkTmp->posicion;
		$newRank->save();
	}
	$user->setFlash('success', "Datos han sido modificados <strong>satisfactoriamente</strong>.");
	$this->redirect(array('admin'));
}
}
