<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'api-challonge-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo Chtml::label('ID Torneo Challonge', 'Api_idTorneo'); ?>
<br/>
<?php echo Chtml::textField('Api[idTorneo]', ''); ?>
<br/><br/><br/><br/>
<div class="row-fluid">
	<div class="col-md-6">
		<?php echo $listaJugadores; ?>
	</div>
	<div class="col-md-6">
		<?php echo $listaPartidos; ?>
		<?php echo "Total Partidas: " . $lengthResultados; ?>
	</div>
</div>
<div class="row-fluid">
	<div class="col-md-12 form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Enviar',
		)); ?>
	</div>
</div>

<?php $this->endWidget(); ?>

<script>

$(document).ready(function()
{
	instalarSelect2('Api_idTorneoVzla', 'Torneo', false);
	$('.listaJugador').each(function(i, obj){
		instalarSelect2($(this).attr('id'), 'Jugador', false);
	});
});

</script>