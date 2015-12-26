<div>
	<?php echo $i+1; ?>)
	<?php echo $jugadorVzla1->nick; ?>
	Vs.
	<?php echo $jugadorVzla2->nick; ?>
	:
	<span class="required">
		<?php echo $ganadorVzla->nick; ?>
	</span>
	<?php echo CHtml::hiddenField('ResultadoPvP[jugador1][' . $i . ']', $player1Id); ?>
	<?php echo CHtml::hiddenField('ResultadoPvP[jugador2][' . $i . ']', $player2Id); ?>
	<?php echo CHtml::hiddenField('ResultadoPvP[jugadorGanador][' . $i . ']', $winnerId); ?>
	<?php echo CHtml::hiddenField('ResultadoPvP[ronda][' . $i . ']', $ronda); ?>
	<?php echo CHtml::hiddenField('ResultadoPvP[numeroRonda][' . $i . ']', $numeroRonda); ?>
</div>
<br/>