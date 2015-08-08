<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'jugador-personaje-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		array(
			'name'=>'jugadorAux',
			'value'=>'$data->idJugador->primer_nombre." ".$data->idJugador->primer_apellido." (".$data->idJugador->nick.")"',
		),
		array(
			'name'=>'personajeAux',
			'value'=>'chtml::image(Yii::app()->baseUrl."/images/".$data->idPersonaje->imagen,"",array("width"=>"24"))',
			'type'=>'raw'
		),
		'primario',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
