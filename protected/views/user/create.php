<?php
/* @var $this UserController */
/* @var $model User */
$this->pageTitle = 'Nuevo Registro';
$this->breadcrumbs=array(
	'Administrar usuarios'=>array('admin'),
	'Nuevo Registro',
);

?>

<?php

    $this->widget('booster.widgets.TbPanel', array(
    'title' => 'Nuevo Registro',
    'headerIcon' => 'pencil',
    'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
    'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'htmlOptions'=>array('style'=>'margin-top:-5px;'),
                'size'=>'small',
                'buttons'=>array(
                    array('label'=>'Lista de Usuarios', 'buttonType'=>'link', 'icon'=>'th-list', 'url'=>array('admin'), 'htmlOptions'=>array('rel'=>'tooltip', 'title'=>'Administrar')),
                    ),
                ),
            ),
    'content' => $this->renderPartial('_form',array('model'=>$model),true,false),
    ));
    
?>

