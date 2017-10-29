<div class="row-fluid" style="width:100%; padding:10px 15px; box-shadow:2px 3px 5px #888888; font-size:14px;">
	<?php
		switch ($data->posicion) {
			case 1:
			case 2:
			case 3:
				$icono=CHtml::image('../../images/medalla'.$data->posicion.'.png','',array('width'=>'20px;'));
				break;
			default:
				$icono="";
				break;
		}
	?>
	<?php echo "<b>".$data->posicion.".</b>"; ?>
	<?php
		if($view==""){
			echo CHtml::link($data->idJugador->nick,'#',array(
			'style'=>'font-weight:bold;',
			'class'=>'detalleJugadorPvp',
			'idJugador'=>$data->id_jugador,
			'idTorneo'=>$data->id_torneo));
			echo $icono;
		}else{
			echo $icono;
			echo " - ";
			echo CHtml::link(
				$data->idTorneo->nombre." (".strftime("%Y",strtotime($data->idTorneo->fecha)).")",
				'#',
				array(
					'style'=>'font-weight:bold;',
					'idTorneo'=>$data->idTorneo->id,
					'class'=>'verImagenTorneo'
				)
			);
		}
	?>
</div>
