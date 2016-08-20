<?php
	$nickVal = $model->nick;
	if ($this->uniqueid === 'jugadorRanking') {
		$nickVal = '<a href="../jugador/' . $model->id . '">' . $model->nick . '</a>';
	}
	$this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'primer_nombre',
		'primer_apellido',
		array(
			'name'=>'nick',
			'value'=>$nickVal,
			'type'=>'raw'
		),
		array(
			'name'=>'estadoAux',
			'value'=>$model->idEstado->nombre,
		),
		/*
		array(
			'name'=>'paisAux',
			'value'=>chtml::image(Yii::app()->baseUrl."/images/".$model->idEstado->idPais->imagen,"",array("width"=>"40")),
			'type'=>'raw'
		),
		*/
		array(
			'name'=>'personajes',
			'value'=>$model->getPersonajes($model->id),
			'type'=>'raw',
		),
		array(
			'name'=>'ranking',
			'value'=>'<span style="color:red; font-weight:bold;">'.$model->getRanking($model->id).'</span>',
			'type'=>'raw',
		),
	),
	'htmlOptions'=>array('style'=>'margin-bottom:20px;')
)); ?>
<div>
	<table class="items table table-striped tablaDetallesJugador">
		<tr>
			<td></td>
			<th>Récord</th>
			<th>Títulos</th>
			<th>% de victorias</th>
		</tr>
		<tr>
			<th><?php echo date('Y'); ?></th>
			<td>
				<?php echo $model->getVictorias($model->id, date('Y'))."-".$model->getDerrotas($model->id, date('Y')); ?>
				<br><span style="color:#8899a6;">G-P</span>
			</td>
			<td><?php echo $model->getTitulos($model->id, date('Y')); ?></td>
			<td><?php echo $model->getWinRate($model->id, date('Y')); ?></td>
		</tr>
		<tr>
			<th>Carrera</th>
			<td>
				<?php echo $model->getVictorias($model->id)."-".$model->getDerrotas($model->id); ?>
				<br><span style="color:#8899a6;">G-P</span>
			</td>
			<td><?php echo $model->getTitulos($model->id); ?></td>
			<td><?php echo $model->getWinRate($model->id); ?></td>
		</tr>
	</table>
</div>
