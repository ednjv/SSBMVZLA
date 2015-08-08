<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle= "Adm. Usuarios";
$this->breadcrumbs=array(
	'Administrar usuarios',
    );
?>

    <?php

    $this->widget('booster.widgets.TbPanel', array(
        'title' => 'Administrar usuarios',
        'headerIcon' => 'user',
        'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
        'padContent' => false,
        'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'htmlOptions'=>array('style'=>'margin-top:-5px;'),
                'size'=>'small',
                'buttons'=>array(
                    array('label'=>'Nuevo Usuario', 'buttonType'=>'link', 'icon'=>'plus', 'url'=>array('create'), 'htmlOptions'=>array('rel'=>'tooltip', 'title'=>'Nuevo Usuario')),
                    ),
                ),
            ),
        'content' => $this->renderPartial('_admin',array('model'=>$model),true,false),
        ));
    
    ?>