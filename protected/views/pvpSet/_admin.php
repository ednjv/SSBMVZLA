<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'pvp-set-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
	array(
		'name'=>'jugador1Aux',
		'value'=>'$data->idJugador1->nick',
	),
	array(
		'name'=>'jugador2Aux',
		'value'=>'$data->idJugador2->nick',
	),
	array(
		'name'=>'jugadorGanadorAux',
		'value'=>'$data->idJugadorGanador->nick',
	),
	array(
		'name'=>'torneoAux',
		'value'=>'$data->idTorneo->nombre',
	),
	'ronda',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
