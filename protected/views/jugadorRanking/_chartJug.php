<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$jugador,
	'attributes'=>array(
		'nick',
		'primer_nombre',
		'primer_apellido',
		array(
			'name'=>'estadoAux',
			'value'=>$jugador->idEstado->nombre,
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
			'name'=>'winrateAux',
			'value'=>$jugador->getWinRate()." %",
		),
	),
)); ?>

<canvas id="myChart" width="600" height="350" style="margin-top:50px;"></canvas>

<script>

var vsJugador=JSON.parse('<?php echo json_encode($vsJugador); ?>');
var ptsVs=JSON.parse('<?php echo json_encode($ptsVs); ?>');

var data = {
    labels: vsJugador,
    datasets: [
        {
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: ptsVs
        },
    ]
};

options = {

    datasetFill : true,

    // Boolean - whether or not the chart should be responsive and resize when the browser does.
    responsive: true,

    // String - Template string for single tooltips
    tooltipTemplate: "<%if (label){%><%= label.split('-')[1]+' '+label.split('-')[2] %>: <%}%><%= value %>",

}

var ctx = document.getElementById("myChart").getContext("2d");
var myNewChart = new Chart(ctx).Line(data,options);

</script>