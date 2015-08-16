<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$jugador,
	'attributes'=>array(
		'primer_nombre',
		'primer_apellido',
		'nick',
		array(
			'name'=>'estadoAux',
			'value'=>$jugador->idEstado->nombre,
		),
		array(
			'name'=>'paisAux',
			'value'=>CHtml::image(Yii::app()->baseUrl."/images/".$jugador->idEstado->idPais->imagen,"",array("width"=>"40")),
			'type'=>'raw'
		),
		array(
			'name'=>'personajes',
			'value'=>$jugador->getPersonajes($jugador->id),
			'type'=>'raw',
		),
		array(
			'name'=>'record',
			'value'=>$jugador->getRecord($jugador->id),
		),
		array(
			'name'=>'WinRate',
			'value'=>$jugador->getWinRate()." %",
		),
	),
)); ?>

<?php
$this->Widget('ext.highcharts.HighchartsWidget', array(
   'options'=>array(
      'title' => array('text' => ''),
      'xAxis' => array(
         'categories' => array($sets[0]['idJugador1']['nick'],$sets[0]['idJugador2']['nick'])
      ),
      'yAxis' => array(
         'title' => array('text' => '')
      ),
      'series' => array(
         array('name' => 'Jane', 'data' => array(1, 0, 4)),
      )
   )
));

?>