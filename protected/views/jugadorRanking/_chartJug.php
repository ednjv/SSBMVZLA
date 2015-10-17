<?php $this->renderPartial('/jugador/_detallesJugador',array(
	'model'=>$jugador
)); ?>

<canvas id="myChart" width="600" height="200" style="margin-top:50px;"></canvas>

<script>

var vsJugador=JSON.parse('<?php echo json_encode($vsJugador); ?>');
var ptsVs=JSON.parse('<?php echo json_encode($ptsVs); ?>');

var data = {
    labels: vsJugador,
    datasets: [
        {
            fillColor: "#A9E2F3",
            strokeColor: "#2E9AFE",
            pointColor: "#428bca",
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
    maintainAspectRatio : false,

    // String - Template string for single tooltips
    tooltipTemplate: "<%if (label){%><%= label.split('-')[1]+' '+label.split('-')[2] %>: <%}%><%= value %>",

}

var ctx = document.getElementById("myChart").getContext("2d");
var myNewChart = new Chart(ctx).Line(data,options);

</script>