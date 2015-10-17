<?php
	$menu=array(
		array(
			'label'=>'Nuevo registro',
			'buttonType'=>'link',
			'icon'=>'plus',
			'url'=>array('create')
		)
	);
?>

<?php $this->Widget('booster.widgets.TbPanel', array(
	'title'=>'Administrar Estados',
	'headerIcon'=>'icon-th-list',
	'htmlOptions'=>array('style'=>'margin-top:10px;'),
	'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
	'headerButtons'=>array(
		array(
			'class'=>'booster.widgets.TbButtonGroup',
			'htmlOptions'=>array('style'=>'margin-top:-5px;'),
			'size'=>'small',
			'buttons'=>$menu
		),
	),
	'content'=>$this->renderPartial('_admin', array(
		'model'=>$model,
		'selectPaises'=>$selectPaises
	),true,false)
));
?>