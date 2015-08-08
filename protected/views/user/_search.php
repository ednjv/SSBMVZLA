<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form" style="margin-left: 20px; margin-top: 15px;">

	<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
		'type'=>'inline',
		)); ?>

		<?php echo $form->textFieldGroup($model,'cedula',array('size'=>20,'maxlength'=>20)); ?>
		<?php $this->widget('booster.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Buscar')); ?>


		<?php $this->endWidget(); ?>

</div><!-- search-form -->