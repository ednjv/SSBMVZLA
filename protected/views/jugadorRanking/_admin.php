<?php echo 'Last updated on: ' . $lastUpdate; ?>
<div class="row-fluid">
  <div class="col-md-5">
    <?php $this->widget('booster.widgets.TbGridView',array(
      'id' => 'jugador-ranking-grid',
      'type' => 'hover',
      'dataProvider' => $model->search(),
      'hideHeader' => false,
      'summaryText' => '',
      'selectionChanged' => 'getChart',
      'columns' => array(
       array(
        'name' => 'posicion',
        'htmlOptions' => array('width' => '5%','style' => 'cursor:pointer;'),
        'sortable' => false,
      ),
       array(
        'name' => 'nickAux',
        'value' => '$data->idJugador->nick',
        'type' => 'raw',
        'htmlOptions' => array('width' => '45%','style' => 'cursor:pointer;'),
        'sortable' => false,
      ),
       array(
        'name' => 'personajeJugador',
        'value' => '$data->idJugador->getPersonajes($data->id_jugador,true)',
        'type' => 'raw',
        'htmlOptions'=>array('width' => '10%', 'style' => 'cursor:pointer;'),
        'sortable'=>false,
      ),
       array(
        'name' => 'puntos',
        'value' => 'number_format($data->puntos,0,".",",")',
        'htmlOptions'=>array('width' => '35%', 'style' => 'cursor:pointer;'),
        'sortable'=>false,
      ),
       array(
        'name' => 'cambio',
        'value' => '$data->getCambio($data->id_jugador)',
        'type' => 'raw',
        'htmlOptions'=>array('width' => '5%', 'style' => 'text-align:right; cursor:pointer;'),
      ),
       array(
        'template' => '',
        'class' => 'booster.widgets.TbButtonColumn',
      ),
     ),
      'htmlOptions'=>array(
       'style' => 'overflow:auto;'
     ),
     )); ?>
   </div>
   <div class="col-md-7">
    <div id="chartJug" class="col-md-12" class="tal"></div>
  </div>
</div>

<script>
  var isSelecting = false;

  function getChart(gridId) {
    var idRank = $.fn.yiiGridView.getSelection(gridId);
    var hasRankSelected = idRank.length;
    if (hasRankSelected && !isSelecting) {
      isSelecting = true;
      $.fancybox.showLoading();
      $.ajax({
        type: 'POST',
        data: {id: idRank[0]},
        url: '<?php echo Yii::app()->request->baseUrl; ?>/index.php/jugadorRanking/getChart',
        success: function(data) {
          isSelecting = false;
          $.fancybox.hideLoading();
          $('#chartJug').html('');
          $('#chartJug').html(data);
        }
      });
    }
  }
</script>

<style type="text/css">
  #chartJug {
    margin-top: 62px;
  }
</style>
