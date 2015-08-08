<?php
$this->breadcrumbs=array(
	'Estados'=>array('admin'),
	'Modificar',
);

	$menu=array(
		array('label'=>'Administrar', 'buttonType'=>'link', 'icon'=>'th-list', 'url'=>array('admin')),
		array('label'=>'Nuevo registro', 'buttonType'=>'link', 'icon'=>'plus', 'url'=>array('create')),
	);
	?>

<?php $this->Widget('booster.widgets.TbPanel', array(
	    'title' => 'Modificar',
    	'headerIcon' => 'pencil',
    	'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
    	'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'htmlOptions'=>array('style'=>'margin-top:-5px;'),
                'size' => 'small',
                'buttons'=>array(
                array('label'=>'Operaciones', 'icon'=>'cog', 
                    'items'=>$menu),
                ),
            ),
        ),
    'content' => $this->renderPartial('_form',array('model'=>$model),true,false),
        ));
?>

