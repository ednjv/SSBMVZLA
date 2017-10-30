<div class="player-detail-container">
  <?php
    $this->renderPartial('/jugador/_detallesJugador', array('model' => $jugador));
  ?>
</div>

<div class="relative">
  <canvas id="myChart" style="margin-top:50px;"></canvas>
</div>

<script>

var vsJugador = JSON.parse('<?php echo json_encode($vsJugador); ?>');
var ptsVs = JSON.parse('<?php echo json_encode($ptsVs); ?>');

var ctx = document.getElementById("myChart").getContext("2d");
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: vsJugador,
    datasets: [
      {
        label: 'points',
        data: ptsVs,
        backgroundColor: [
          '#A9E2F3'
        ],
        borderColor: [
          '#2E9AFE'
        ],
        borderWidth: 1,
        radius: 5
      }
    ]
  },
  options: {
    layout: {
      padding: {
        bottom: 20,
        left: 50,
        right: 50
      }
    },
    legend: {
      display: false
    },
    responsive: true,
    scales: {
      xAxes: [{
        ticks: {
          callback: function(value, index, values) {
            return value.split('||')[0];
          }
        }
      }]
    },
    tooltips: {
      titleFontStyle: 'normal',
      bodyFontStyle: 'bold',
      displayColors: false,
      titleAlign: 'left',
      bodyAlign: 'left',
      footerAlign: 'left',
      yAlign: 'top',
      xAlign: 'center',
      caretSize: 10,
      bodyFontSize: 10,
      titleFontSize: 10,
      footerFontSize: 10,
      callbacks: {
        title: function(tooltipItem, data) {
          var tournament = data['labels'][tooltipItem[0]['index']].split('||')[1];
          return tournament;
        },
        afterTitle: function(tooltipItem, data) {
          var playerName = 'vs. ' + data['labels'][tooltipItem[0]['index']].split('||')[0];
          return playerName;
        },
        label: function(tooltipItem, data) {
          var ratingResult = data['labels'][tooltipItem['index']].split('||')[2];
          return ratingResult;
        },
        labelTextColor: function(tooltipItem, chart) {
          var ratingResult = chart.config.data['labels'][tooltipItem['index']].split('||')[2];
          if (ratingResult.indexOf('Won') !== -1) {
            return '#0A0';
          } else {
            return '#C00';
          }
        },
        footer: function(tooltipItem, data) {
          var elo = data['datasets'][0]['data'][tooltipItem[0]['index']];
          return elo + ' pts';
        }
      }
    }
  }
});

</script>

<style type="text/css">
  .player-detail-container {
    padding-left: 50px;
    padding-right: 50px;
  }

  .table-striped tr {
    height: 41px;
  }
</style>
