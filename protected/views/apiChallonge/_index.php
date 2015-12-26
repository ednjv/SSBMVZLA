<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'api-challonge-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php echo CHtml::label('ID Torneo Challonge', 'Api_idTorneo'); ?>
<br/>
<?php echo CHtml::textField('Api[idTorneo]', ''); ?>
<br/><br/><br/><br/>
<div class="row-fluid">
	<div class="col-md-6">
		<?php echo $listaJugadores; ?>
		<?php echo $listaPartidos; ?>
		<?php echo "Total Partidas: " . $lengthResultados; ?>
	</div>
	<div class="col-md-6">
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