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
			'filter'=>$this->widget('ext.booster.widgets.TbSelect2',array(
				'model'=>$model,
				'data'=>$selectPersonajes,
				'attribute'=>'personajePrimario',
				'options'=>array(
					'placeholder'=>'Personaje',
					'allowClear'=>true,
					'width'=>'100%',
					'formatResult'=>'js:formatResult',
					'formatSelection'=>'js:formatSelection',
				),
			),true,false),
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
function formatResult(data){
	var backSlash="";
	if(location.href=="http://ssbmvenezuela.byethost11.com/SSBMVZLA/index.php"){
		backSlash="";
	}else{
		if(location.href!="http://ssbmvenezuela.byethost11.com/SSBMVZLA/"){
			backSlash="../../";
		}
	}
	var datos=data.text;
	var splitted=datos.split("|");
	var imagen='<img src="'+backSlash+'images/'+splitted[1]+'" width="24"/>';
	var descripcion=splitted[0];
	return imagen+" "+descripcion;
}

function formatSelection(data){
	var datos=data.text;
	var splitted=datos.split("|");
	var descripcion=splitted[0];
	return descripcion;
}

function afterUpdate(){
	$("#Jugador_personajePrimario").select2({
		allowClear: true,
		width: '100%',
		placeholder: 'Personaje',
		formatResult: function(data){
			var backSlash="";
			if(location.href=="http://ssbmvenezuela.byethost11.com/SSBMVZLA/index.php"){
				backSlash="";
			}else{
				if(location.href!="http://ssbmvenezuela.byethost11.com/SSBMVZLA/"){
					backSlash="../../";
				}
			}
			var datos=data.text;
			var splitted=datos.split("|");
			var imagen='<img src="'+backSlash+'images/'+splitted[1]+'" width="24"/>';
			var descripcion=splitted[0];
			return imagen+" "+descripcion;
		},
		formatSelection: function(data){
			var datos=data.text;
			var splitted=datos.split("|");
			var descripcion=splitted[0];
			return descripcion;
		},
	});
}
</script>