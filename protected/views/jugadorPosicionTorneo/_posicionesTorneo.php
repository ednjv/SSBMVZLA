<div class="col-md-6 col-xs-12">
  <?php
    $cs=Yii::app()->clientScript;
    $cs->scriptMap=array(
      'jquery.js'=>false,
      'jquery.ui.js' => false,
    );
  ?>
  <h5><b>Placings</b></h5>
  <hr/>
  <?php $this->widget('booster.widgets.TbListView', array(
		'id'=>'listViewPosiciones',
		'dataProvider'=>$posicionTorneo,
		'itemView'=>'//layouts/_posicionesTorneo',
		'afterAjaxUpdate'=>'CargarClickDetalleJugador',
		'viewData'=>array(
			'view'=>""
		),
		'summaryText'=>''
	)); ?>
</div>

<div class="col-md-6 col-xs-12">
	<div id="resultadoPvpJugadorTorneo"></div>
</div>
