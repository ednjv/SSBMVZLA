<?php
	$cs=Yii::app()->clientScript;
	$cs->scriptMap=array(
		'jquery.js'=>false,
		'jquery.ui.js' => false,
	);
?>
<h4>Rondas</h4>
<?php $this->widget('booster.widgets.TbListView', array(
	'id'=>'listViewPvps',
	'dataProvider'=>$pvpsJugadorTorneo,
	'itemView'=>'//layouts/_pvpsJugadorTorneo',
	'viewData'=>array(
		'jugadorActual'=>$jugadorActual
	),
	'summaryText'=>''
)); ?>