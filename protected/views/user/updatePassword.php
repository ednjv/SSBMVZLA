<?php
/* @var $this UserController */
/* @var $modelUser User */
/* @var $model UserUpdatePassword */
/* @var $form CActiveForm */
?>
<?php
    $this->pageTitle= Yii::app()->name . ' - Cambio de contraseña';
    $user = Yii::app()->getUser(); 
    $this->breadcrumbs=array(
	'Usuarios'=>$user->checkAccess('Admin') ? array('admin'): array('view','id'=>$user_id),
	'Cambiar contraseña',
);
    
   if($user->checkAccess('Admin')){
       $operaciones=array(
           array('label'=>'Nuevo Usuario', 'url'=>array('create')),
           array('label'=>'Eliminar cuenta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$modelUser->id),'confirm'=>'¿Estás seguro de realizar esta acción?')),
           array('label'=>'Administrar Usuarios', 'url'=>array('admin')),
           array('label'=>'Perfil', 'url'=>array('view', 'id'=>$user_id)),
           array('label'=>'Modificar datos', 'url'=>array('update', 'id'=>$user_id)),  
           );
   } else {
        $operaciones=array(
                array('label'=>'Ver Perfil', 'url'=>array('view', 'id'=>$user_id)),
                );
       
   }
    
$this->widget('booster.widgets.TbPanel', array(
	    'title' => 'Modificar contraseña',
	    'headerIcon' => 'pencil',
      'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'htmlOptions'=>array('style'=>'margin-top:-5px;'),
                'size'=>'small',
                'buttons'=>array(
                    array('label'=>'Operaciones', 'icon'=>'cog', 
                        'items'=>$operaciones),
                    ),
                ),
            ),
	    'content' => $this->renderPartial('_formPwdUpdate',array('model'=>$model),true,false),
	    ));

?>    