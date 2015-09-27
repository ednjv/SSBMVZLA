<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'jugador-posicion-torneo-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son obligatorios.</p>

<!-- <?php echo $form->errorSummary($model); ?>
 -->
	<?php echo $form->select2Group($model,'id_jugador',array(
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

	<?php echo $form->textFieldGroup($model,'posicion',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Guardar' : 'Modificar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
