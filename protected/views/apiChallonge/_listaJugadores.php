<h4><?php echo $idTorneo; ?></h4>
<input type="hidden" value="<?php echo $idTorneo; ?>" name="ApiTorneo[idTorneo]"/>
<p>
	Lista de jugadores, por favor seleccione el torneo al que pertenece
	localmente para cargar las posiciones. Seguidamente seleccione el
	jugador al que representa en la base de datos local el jugador de
	challonge de la izquierda. Verifique la información antes de
	presionar Enviar nuevamente
</p>
<div class="form-group">
	<?php echo CHtml::label('Torneo Local', 'ListaJugadorLocal_idTorneoVzla', array('class'=>'control-label')); ?>
	<br/>
	<?php echo CHtml::dropDownList('ListaJugadorLocal[idTorneoVzla]', '', $selectTorneos); ?>
</div>
<b>Lista de participantes</b>
<?php
	$i = 0;
	foreach($jsonParticipantes as $key => $value){
		$participant = $value['participant'];
		$idParticipante = $participant['id'];
		$nickParticipante = $participant['name'];
		$rankParticipante = $participant['final_rank'];
		$jugadorLocal = '';
		$busqJugadorVzla = Jugador::model()->find('nick LIKE :nick', array(':nick'=>$nickParticipante));
		if($busqJugadorVzla != null){
			$jugadorLocal = $busqJugadorVzla->id;
		}
		$arrayJugadorApi = array($idParticipante=>$nickParticipante);
?>
<div class="row-fluid">
	<div class="col-md-1">
		<div class="form-group">
			<?php echo $rankParticipante; ?>)
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo CHtml::dropDownList('ListaJugadorApi[' . $i . ']', $idParticipante, $arrayJugadorApi, array('class'=>'listaJugador')); ?>
			<?php echo CHtml::hiddenField('ListaJugadorLocal[posicionJugador][' . $i . ']', $rankParticipante); ?>
		</div>
	</div>
	<div class="col-md-1">
		<div class="form-group">
			=>
		</div>
	</div>
	<div class="col-md-7">
		<div class="form-group">
			<?php echo CHtml::dropDownList('ListaJugadorLocal['.$i.']', $jugadorLocal, $selectJugadores, array('class'=>'listaJugador')); ?>
		</div>
	</div>
</div>
<?php $i++; } //Cierra el foreach ?>