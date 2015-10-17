<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'jugador-grid',
'type'=>'striped',
'dataProvider'=>$model->search(),
'filter'=>$model,
'afterAjaxUpdate'=>'afterUpdate',
'columns'=>array(
		'nick',
		array(
			'name'=>'estadoAux',
			'value'=>'$data->idEstado->nombre',
		),
		/*array(
			'name'=>'paisAux',
			'value'=>'chtml::image(Yii::app()->baseUrl."/images/".$data->idEstado->idPais->imagen,"",array("width"=>"40"))." ".$data->idEstado->idPais->nombre',
			'type'=>'raw'
		),*/
		array(
			'name'=>'personajePrimario',
			'value'=>'$data->getPersonajes($data->id, true)',
			'type'=>'raw',
			'filter'=>CHtml::activeDropDownList($model, 'personajePrimario', $selectPersonajes, array('empty'=>''))
		),
		array(
			'name'=>'recordAux',
			'value'=>'$data->getVictorias($data->id)."-".$data->getDerrotas($data->id)." (G-P)"',
			'filter'=>'',
		),
		array(
			'name'=>'winrateAux',
			'value'=>'$data->getWinRate($data->id)." %"',
			'filter'=>'',
		),
		array(
			'name'=>'efectividad',
			'value'=>'$data->getEfectividad($data->id)',
			'filter'=>'',
		),
array(
'template'=>'{view}',
'class'=>'booster.widgets.TbButtonColumn',
),
),
'htmlOptions'=>array(
	'style'=>'overflow:auto;'
),
)); ?>

<script>

function afterUpdate(){
	instalarSelect2('Jugador_personajePrimario', 'Personaje', true);
}

$(document).ready(function()
{
	instalarSelect2('Jugador_personajePrimario', 'Personaje', true);
});

</script>