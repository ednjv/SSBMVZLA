<?php echo "Actualizado el: ".$lastUpdate; ?>
<div class='row-fluid'>
	<div class='col-md-5'>
		<?php $this->widget('booster.widgets.TbGridView',array(
		'id'=>'jugador-ranking-grid',
		'dataProvider'=>$model->search(),
		'hideHeader'=>true,
		'summaryText'=>'',
		'selectionChanged'=>'getChart',
		'columns'=>array(
			array(
				'name'=>'posicion',
				'htmlOptions'=>array('width'=>'5%','style'=>'cursor:pointer;'),
			),
			array(
				'name'=>'nickAux',
				'value'=>'$data->idJugador->nick." ".$data->idJugador->getPersonajes($data->idJugador->id,true)',
				'type'=>'raw',
				'htmlOptions'=>array('width'=>'30%','style'=>'cursor:pointer;'),
			),
			array(
				'name'=>'puntos',
				'value'=>'number_format($data->puntos,0,".",",")',
				'htmlOptions'=>array('width'=>'55%','style'=>'text-align:right; cursor:pointer;'),
			),
			array(
				'name'=>'cambio',
				'value'=>'$data->getCambio($data->id_jugador)',
				'type'=>'raw',
				'htmlOptions'=>array('width'=>'10%','style'=>'text-align:right; cursor:pointer;'),
			),
		array(
		'template'=>'',
		'class'=>'booster.widgets.TbButtonColumn',
		),
		),
		)); ?>
	</div>
	<div class='col-md-7'>
		<div id="chartJug" class='col-md-12'></div>
	</div>
</div>

<script>

function getChart(id){
	var idRank=$.fn.yiiGridView.getSelection(id);
	$.ajax({
		type:"POST",
		data:{id:idRank[0]},
		url:"<?php echo Yii::app()->request->baseUrl; ?>/index.php/jugadorRanking/getChart",
		success:function(data){
			$("#chartJug").html("");
			$("#chartJug").html(data);
		}
	});
}

</script>