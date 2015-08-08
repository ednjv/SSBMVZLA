<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'pvp-set-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son obligatorios.</p>

<!-- <?php echo $form->errorSummary($model); ?>
 -->
	<?php echo $form->select2Group($model,'id_jugador_1',array(
		'widgetOptions'=>array(
			'data'=>$selectJugadores,
			'options'=>array(
				'allowClear'=>true,
				'width'=>'100%',
			),
			'htmlOptions'=>array(
				'placeholder'=>'Seleccione',
	)))); ?>

	<?php echo $form->select2Group($model,'id_jugador_2',array(
		'widgetOptions'=>array(
			'data'=>$selectJugadores,
			'options'=>array(
				'allowClear'=>true,
				'width'=>'100%',
			),
			'htmlOptions'=>array(
				'placeholder'=>'Seleccione',
	)))); ?>

	<?php echo $form->select2Group($model,'id_jugador_ganador',array(
		'widgetOptions'=>array(
			'data'=>$selectJugadores,
			'options'=>array(
				'allowClear'=>true,
				'width'=>'100%',
			),
			'htmlOptions'=>array(
				'placeholder'=>'Seleccione',
	)))); ?>

	<?php echo $form->select2Group($model,'id_torneo',array(
		'widgetOptions'=>array(
			'data'=>$selectTorneos,
			'options'=>array(
				'allowClear'=>true,
				'width'=>'100%',
			),
			'htmlOptions'=>array(
				'placeholder'=>'Seleccione',
	)))); ?>

	<?php echo $form->textFieldGroup($model,'ronda',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>50)))); ?>

	<?php echo $form->textFieldGroup($model,'numero_ronda',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'elo_jugador_1',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

	<?php echo $form->textFieldGroup($model,'elo_jugador_2',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Guardar' : 'Modificar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
