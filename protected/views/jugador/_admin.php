<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'jugador-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'afterAjaxUpdate'=>'afterUpdate',
'columns'=>array(
		'nick',
		array(
			'name'=>'estadoAux',
			'value'=>'$data->idEstado->nombre',
		),
		array(
			'name'=>'paisAux',
			'value'=>'chtml::image(Yii::app()->baseUrl."/images/".$data->idEstado->idPais->imagen,"",array("width"=>"40"))." ".$data->idEstado->idPais->nombre',
			'type'=>'raw'
		),
		array(
			'name'=>'personajes',
			'value'=>'$data->getPersonajes($data->id)',
			'type'=>'raw',
			'filter'=>$this->widget('ext.booster.widgets.TbSelect2',array(
				'model'=>$model,
				'data'=>$selectPersonajes,
				'attribute'=>'personajes',
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
			'value'=>'$data->getRecord($data->id)',
			'filter'=>'',
		),
		array(
			'name'=>'winrateAux',
			'value'=>'$data->getWinRate()." %"',
			'filter'=>'',
		),
array(
'template'=>'{view}',
'class'=>'booster.widgets.TbButtonColumn',
),
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
	return descripcion+" "+imagen;
}

function formatSelection(data){
	var datos=data.text;
	var splitted=datos.split("|");
	var descripcion=splitted[0];
	return descripcion;
}

function afterUpdate(){
	$("#Jugador_personajes").select2({
		allowClear: true,
		width: '100%',
		placeholder: 'Personaje',
		formatResult: function(data){
			var datos=data.text;
			var splitted=datos.split("|");
			var imagen='<img src="../../images/'+splitted[1]+'" width="24"/>';
			var descripcion=splitted[0];
			return descripcion+" "+imagen;
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