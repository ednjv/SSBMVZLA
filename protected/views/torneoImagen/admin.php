<?php
$this->breadcrumbs=array(
	'Torneo Imagens'=>array('admin'),
	'Administrar',
);
?>
<?php $this->Widget('booster.widgets.TbPanel', array(
	    'title' => 'Administrar Torneo Imagens',
    	'headerIcon' => 'icon-th-list ',
    	'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
    	'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'htmlOptions'=>array('style'=>'margin-top:-5px;'),
                'size'=>'small',
                'buttons'=>array(
                    array('label'=>'Nuevo registro', 'buttonType'=>'link', 'icon'=>'plus', 'url'=>array('create')),
                ),
            ),
        ),
    'content' => $this->renderPartial('_admin',array('model'=>$model),true,false),
        ));
?>
