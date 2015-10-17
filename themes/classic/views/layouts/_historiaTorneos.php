<ul style="width:100%; padding-left:0px; box-shadow:2px 3px 5px #888888;">
	<li style='padding:10px 15px; display:block;'>
		<span style='float:left; font-weight:bold;'>
			<?php
				if($data->id_jugador_1==$model->id) {
					echo "vs. ".$data->idJugador2->nick;
				}else{
					echo "vs. ".$data->idJugador1->nick;
				}
			?>
		</span>
		<span style='float:right; background-color:#aab2bd; border-radius:10px; color:#fff; display:inline-block; font-size:12px; font-weight:700; line-height: 1; min-width:10px; padding:3px 7px; text-align:center; vertical-align:baseline; white-space:nowrap;'>
			<?php echo $data->ronda; ?>
		</span>
		<span style="display:inline-block; float:right; font-weight:bold; margin-right:10px;">
			<?php
				if($data->id_jugador_ganador!=$model->id){
					echo "L ";
				}else{
					echo "W";
				}
			?>
		</span>
		<br>
		<?php //echo CHtml::image(Yii::app()->baseUrl."/images/".$data->idTorneo->idEstado->idPais->imagen,"",array('width'=>'40')); ?>
		<?php echo $data->idTorneo->nombre; ?>
		<span style="float:right; font-size:14px; color:#8899a6;">
			<?php echo strftime("%B %d, %Y",strtotime(str_replace("-", "/", $data->idTorneo->fecha))); ?>
		</span>
	</li>
</ul>