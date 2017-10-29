<?php
  $cs=Yii::app()->clientScript;
  $cs->scriptMap=array(
    'jquery.js'=>false,
    'jquery.ui.js' => false,
  );

  $iconLeft = '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
  $iconRight = '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
?>
<?php
  if ($jugadorActual == $data->id_jugador_1) {
    $jugador1 = $data->idJugador1->nick;
    $jugador2 = $data->idJugador2->nick;
    if ($data->id_jugador_1 == $data->id_jugador_ganador) {
      $resultado = ' ' . $iconRight . ' ';
    } else {
      $resultado = ' ' . $iconLeft . ' ';
    }
  }else{
    $jugador1 = $data->idJugador2->nick;
    $jugador2 = $data->idJugador1->nick;
    if ($data->id_jugador_2 == $data->id_jugador_ganador) {
      $resultado = ' ' . $iconRight . ' ';
    } else {
      $resultado = ' ' . $iconLeft . ' ';
    }
  }
?>
<div class="row" style="width:100%; padding:10px 15px; box-shadow:2px 3px 5px #888888; font-size:14px;">
  <div class="col-md-9 col-xs-8">
    <?php echo $jugador1 . $resultado . $jugador2; ?>
  </div>
  <div class="col-md-3 col-xs-4">
    <span style='background-color:#aab2bd; border-radius:10px; color:#fff; display:inline-block; font-size:12px; font-weight:700; line-height: 1; min-width:10px; padding:3px 7px; text-align:center; vertical-align:baseline; white-space:nowrap;'>
      <?php echo $data->ronda; ?>
    </span>
  </div>
</div>
