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
				'htmlOptions'=>array('width'=>'5%'),
			),
			array(
				'name'=>'nickAux',
				'value'=>'$data->idJugador->nick." ".$data->idJugador->getPersonajes($data->idJugador->id,true)',
				'type'=>'raw',
				'htmlOptions'=>array('width'=>'30%'),
			),
			array(
				'name'=>'puntos',
				'value'=>'number_format($data->puntos,0,".",",")',
				'htmlOptions'=>array('width'=>'55%','style'=>'text-align:right;'),
			),
			array(
				'name'=>'cambio',
				'value'=>'$data->getCambio($data->id_jugador)',
				'type'=>'raw',
				'htmlOptions'=>array('width'=>'10%','style'=>'text-align:right;'),
			),
		array(
		'template'=>'',
		'class'=>'booster.widgets.TbButtonColumn',
		),
		),
		)); ?>
	</div>
	<div id="chart" class='col-md-7'></div>
</div>

<script>

function getChart(id){
	var idRank=$.fn.yiiGridView.getSelection(id);
	$.ajax({
		type:"POST",
		data:{id:idRank[0]},
		url:"<?php echo Yii::app()->request->baseUrl; ?>/index.php/PvPSet/getChart",
		success:function(data){
			$("#chart").html("");
			$("#chart").html(data);
		}
	});
}

</script>