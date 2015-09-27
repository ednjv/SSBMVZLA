<?php
$cs=Yii::app()->clientScript;
$cs->scriptMap=array(
	'jquery.js'=>false,
	'jquery.ui.js' => false,
);?>
<div class='row-fluid' style="width:70%; padding:10px 15px; box-shadow:2px 3px 5px #888888;">
	<div class='row'>
		<div class='col-md-6' style="font-weight:bold; font-size:16px;">
		<?php echo CHtml::image(Yii::app()->baseUrl."/images/".$personajePrimario->idPersonaje->imagen,"",array('width'=>'24')); ?>
		<?php echo $modelJugadorVs->nick; ?>
		</div>
		<div class='col-md-6'>
			<?php //echo CHtml::image(Yii::app()->baseUrl."/images/".$modelJugadorVs->idEstado->idPais->imagen,"",array('width'=>'40')); ?>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-12' style='font-weight:bold; font-size:18px;'>
			<?php echo $recordVs; ?>
		</div>
	</div>
</div>
<br>
<?php $this->widget('booster.widgets.TbListView', array(
	'id'=>'listViewVsJugador',
	'dataProvider'=>$allSets,
	'itemView'=>'//layouts/_historiaVs',
	'viewData'=>array(
		'jugadorActual'=>$jugadorActual
	),
	'summaryText'=>''
)); ?>