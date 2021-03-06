<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'jugador-personaje-form',
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

	<?php echo $form->select2Group($model,'id_personaje',array(
		'widgetOptions'=>array(
			'data'=>$selectPersonajes,
			'options'=>array(
				'allowClear'=>true,
				'width'=>'100%',
				'formatResult'=>'js:formatResult',
				'formatSelection'=>'js:formatSelection',
			),
			'htmlOptions'=>array(
				'placeholder'=>'Seleccione',
	)))); ?>

	<?php echo $form->textFieldGroup($model,'primario',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>

<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>$model->isNewRecord ? 'Guardar' : 'Modificar',
		)); ?>
</div>

<?php $this->endWidget(); ?>

<script>
function formatResult(data){
	var datos=data.text;
	var splitted=datos.split("|");
	var imagen='<img src="../../images/'+splitted[1]+'" width="24"/>';
	var descripcion=splitted[0];
	return descripcion+" "+imagen;
}

function formatSelection(data){
	var datos=data.text;
	var splitted=datos.split("|");
	var descripcion=splitted[0];
	return descripcion;
}
</script>