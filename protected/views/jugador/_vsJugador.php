<div class='row-fluid' style="width:70%; border-radius:4px; box-shadow:0 1px 2px rgba(0, 0, 0, 0.2); padding:10px 15px;">
	<div class='row'>
		<div class='col-md-6' style="font-weight:bold; font-size:16px;">
		<?php echo CHtml::image(Yii::app()->baseUrl."/images/".$personajePrimario->idPersonaje->imagen,"",array('width'=>'24')); ?>
		<?php echo $modelJugadorVs->nick; ?>
		</div>
		<div class='col-md-6'>
			<?php echo CHtml::image(Yii::app()->baseUrl."/images/".$modelJugadorVs->idEstado->idPais->imagen,"",array('width'=>'40')); ?>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-12' style='font-weight:bold; font-size:18px;'>
			<?php echo $recordVs; ?>
		</div>
	</div>
</div>
<br>
<ul style="width:70%; padding-left: 0px;">
<?php foreach($allSets as $set){ ?>
	<li style='padding:10px 15px; display:block; border:1px solid gray;'>
		<span style='float:right; background-color:#aab2bd; border-radius:10px; color:#fff; display:inline-block; font-size:12px; font-weight:700; line-height: 1; min-width:10px; padding:3px 7px; text-align:center; vertical-align:baseline; white-space:nowrap;'>
			<?php echo $set->ronda;	?>
		</span>
		<span style="display:inline-block; float:right; font-weight:bold; margin-right:10px;">
			<?php
				if($set->id_jugador_ganador!=$jugadorActual){
					echo "L ";
				}else{
					echo "W";
				}
			?>
		</span>
		<br>
		<?php echo CHtml::image(Yii::app()->baseUrl."/images/".$set->idTorneo->idEstado->idPais->imagen,"",array('width'=>'40')); ?>
		<?php echo $set->idTorneo->nombre; ?>
		<span style="float:right; font-size:14px;">
			<?php echo strftime("%B %d, %Y",strtotime(str_replace("-", "/", $set->idTorneo->fecha))); ?>
		</span>
	</li>
<?php }?>
</ul>