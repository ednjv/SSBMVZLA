<?php
	$menu=array(
		array(
			'label'=>'Administrar',
			'buttonType'=>'link',
			'icon'=>'th-list',
			'url'=>array('admin')
		)
	);
?>

<?php $this->Widget('booster.widgets.TbPanel', array(
	'title'=>'Nuevo registro',
	'headerIcon'=>'icon-th-list',
	'htmlOptions'=>array('style'=>'margin-top:10px;'),
	'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
	'headerButtons'=>array(
		array(
			'class'=>'booster.widgets.TbButtonGroup',
			'htmlOptions'=>array('style'=>'margin-top:-5px;'),
			'size'=>'small',
			'buttons'=>$menu
		)
	),
	'content'=>$this->renderPartial('_form', array(
		'model'=>$model,
		'selectPaises'=>$selectPaises
	),true,false)
));
?>