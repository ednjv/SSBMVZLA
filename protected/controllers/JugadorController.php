<?php

class JugadorController extends Controller
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
	'actions'=>array('view','admin','CompararJugador','GetJugador'),
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
$todosSets=PvpSet::model()->historiaTorneos($id);
$countSets=PvpSet::model()->findAll(array(
	'condition'=>'id_jugador_1=:id OR id_jugador_2=:id',
	'params'=>array(':id'=>$id),
	'with'=>array('idTorneo'),
	'order'=>'idTorneo.fecha desc, t.id desc',
));	
$countTorneos=PvpSet::model()->count(array(
	'condition'=>'id_jugador_1=:id OR id_jugador_2=:id',
	'params'=>array(':id'=>$id),
	'group'=>'id_torneo',
));
$ultimosTorneos=JugadorPosicionTorneo::model()->getPosiciones(
	"id_jugador=:idJugador",
	array("idJugador"=>$id),
	"idTorneo.fecha desc",
	5,
	array('idTorneo')
);
$this->render('view',array(
'model'=>$this->loadModel($id),
'todosSets'=>$todosSets,
'countSets'=>$countSets,
'countTorneos'=>$countTorneos,
'ultimosTorneos'=>$ultimosTorneos,
));
}

/**
* Creates a new model.
* If creation is successful, the browser will be redirected to the 'view' page.
*/
public function actionCreate()
{
$model=new Jugador;
$user = Yii::app()->user;
$selectEstados=Estado::model()->selectEstados();
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['Jugador']))
{
$model->attributes=$_POST['Jugador'];
if($model->save()){
	$user->setFlash('success', "Datos han sido guardados <strong>satisfactoriamente</strong>.");
	$this->redirect(array('create'));
}
}

$this->render('create',array(
'model'=>$model,
'selectEstados'=>$selectEstados,
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
$selectEstados=Estado::model()->selectEstados();

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

if(isset($_POST['Jugador']))
{
$model->attributes=$_POST['Jugador'];
if($model->save()){
			$user->setFlash('success', "Datos han sido modificados <strong>satisfactoriamente</strong>.");
			$this->redirect(array('admin'));
		}
}

$this->render('update',array(
'model'=>$model,
'selectEstados'=>$selectEstados,
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
$dataProvider=new CActiveDataProvider('Jugador');
$this->render('index',array(
'dataProvider'=>$dataProvider,
));
}

/**
* Manages all models.
*/
public function actionAdmin()
{
$model=new Jugador('search');
$selectPersonajes=Personaje::model()->selectPersonajes();
$model->unsetAttributes();  // clear any default values
if(isset($_GET['Jugador']))
$model->attributes=$_GET['Jugador'];

$this->render('admin',array(
'model'=>$model,
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
$model=Jugador::model()->findByPk($id);
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
if(isset($_POST['ajax']) && $_POST['ajax']==='jugador-form')
{
echo CActiveForm::validate($model);
Yii::app()->end();
}
}

public function actionCompararJugador(){
	$jugadorActual=$_GET['jugadorActual'];
	$jugadorComparar=$_GET['jugadorComparar'];
	$modelJugadorVs=Jugador::model()->findByPk($jugadorComparar);
	$personajePrimario=JugadorPersonaje::model()->find(array(
		'condition'=>'id_jugador=:jugadorComparar AND primario=1',
		'params'=>array(':jugadorComparar'=>$jugadorComparar)
	));
	if($jugadorActual!=$jugadorComparar){
		$recordVs=Jugador::model()->getRecordVs($jugadorActual,$jugadorComparar);
	}else{
		$recordVs="0 W - 0 L";
	}
	$allSets=PvpSet::model()->historiaVs($jugadorActual,$jugadorComparar);
	return $this->renderPartial('_vsJugador',array(
		'personajePrimario'=>$personajePrimario,
		'modelJugadorVs'=>$modelJugadorVs,
		'recordVs'=>$recordVs,
		'allSets'=>$allSets,
		'jugadorActual'=>$jugadorActual,
	),false,true);
}

public function actionGetJugador()
{
	$nick = $_GET['nick'];
	if($nick!=""){
		$model = Utiles::listDataExtJson('Jugador', 'id', array('nick'),' ','nick LIKE "%'.$nick.'%"');
		echo $model;
	}
}
}
