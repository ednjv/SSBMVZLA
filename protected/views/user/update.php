<?php
/* @var $this UserController */
/* @var $model User */
$this->pageTitle= 'Modificar Usuario';
$user = Yii::app()->getUser();
$this->breadcrumbs=array(
	'Administrar usuarios'=>$user->checkAccess('Admin') ? array('admin'): array('view','id'=>$model->id),
	$model->username=>array('view','id'=>$model->id),
	'Modificar',
);
?>


<?php
    if($user->checkAccess('Admin')){
       /* $this->menu=array(
               array('label'=>'Nuevo Usuario', 'url'=>array('create'), 'linkOptions'=>array('class'=>'button secondary small')),
               array('label'=>'Eliminar cuenta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id), 'class'=>'button secondary small','confirm'=>'¿Estás seguro de realizar esta acción?')),
               array('label'=>'Administrar Usuarios', 'url'=>array('admin'), 'linkOptions'=>array('class'=>'button secondary small')),
               array('label'=>'Perfil', 'url'=>array('view', 'id'=>$model->id), 'linkOptions'=>array('class'=>'button secondary small')),
       );   */

	    $this->widget('booster.widgets.TbPanel', array(
	    'title' => 'Modificar usuario <b style="color:#4295B6">'.$model->username. '</b>',
	    'headerIcon' => 'pencil',
	    'content' => $this->renderPartial('_form',array('model'=>$model),true,false),
	    ));

    } 

?>



