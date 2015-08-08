<?php
$this->breadcrumbs=array(
	'Torneos'=>array('admin'),
	$model->id,
);

$menu=array(
array('label'=>'Nuevo registro', 'buttonType'=>'link', 'icon'=>'plus', 'url'=>array('create')),
array('label'=>'Modificar', 'icon'=>'pencil','url'=>array('update','id'=>$model->id)),
array('label'=>'Eliminar','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro que desea borrar este elemento?')),
array('label'=>'Administrar', 'buttonType'=>'link', 'icon'=>'th-list', 'url'=>array('admin')),
);
?>


<?php $this->beginWidget('booster.widgets.TbPanel', array(
	    'title' => 'Detalles de registro '. $model->id,
    	'headerIcon' => 'eye-open',
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
        ));
?>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'nombre',
		'id_estado',
		'fecha',
),
)); ?>

<?php $this->endWidget();
?>
