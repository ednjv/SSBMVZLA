<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'estado-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Campos con <span class="required">*</span> son obligatorios.</p>

<?php echo $form->textFieldGroup($model, 'nombre', array(
	'widgetOptions'=>array(
		'htmlOptions'=>array(
			'class'=>'span5',
			'maxlength'=>100
		)
	)
)); ?>

<?php echo $form->dropDownListGroup($model, 'id_pais', array(
	'widgetOptions'=>array(
		'data'=>$selectPaises,
		'htmlOptions'=>array(
			'empty'=>''
		)
	)
)); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType'=>'submit',
		'context'=>'primary',
		'label'=>$model->isNewRecord ? 'Guardar' : 'Modificar',
	)); ?>
</div>

<?php $this->endWidget(); ?>

<script>

$(document).ready(function()
{
	instalarSelect2('Estado_id_pais', 'País', true);
});

</script>