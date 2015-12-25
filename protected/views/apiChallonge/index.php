<?php $this->Widget('booster.widgets.TbPanel', array(
	'title'=>'Api Integration',
	'headerIcon'=>'icon-th-list',
	'htmlOptions'=>array('style'=>'margin-top:10px;'),
	'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
	'content'=>$this->renderPartial('_index', array(
		'peticion'=>$peticion,
		'listaJugadores'=>$listaJugadores,
		'listaPartidos'=>$listaPartidos,
		'lengthResultados'=>$lengthResultados
	),true,false)
));
?>