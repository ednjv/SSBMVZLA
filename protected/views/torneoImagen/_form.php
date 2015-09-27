<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'torneo-imagen-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son obligatorios.</p>

<!-- <?php echo $form->errorSummary($model); ?>
 -->
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

	<?php echo $form->textFieldGroup($model,'descripcion',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5','maxlength'=>200)))); ?>

	<?php echo $form->label($model,'imagen'); ?>
	<?php $this->widget('CMultiFileUpload',array(
		'accept'=>'jpeg|jpg|gif|png',
		'duplicate'=>'Duplicate file!',
		'name'=>'picture',
		'denied'=>'Invalid file type',
	)); ?>
	<?php echo $form->error($model,'imagen'); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Guardar' : 'Modificar',
		)); ?>
</div>

<?php $this->endWidget(); ?>
