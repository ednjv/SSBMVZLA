<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); 
?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios</p>
<!--
	<?php echo $form->errorSummary($model); ?>
-->


		<?php echo $form->textFieldGroup($model,'cedula',array('size'=>20,'maxlength'=>20)); ?>

		<?php echo $form->textFieldGroup($model,'username',array('size'=>20,'maxlength'=>20)); ?>

		<?php echo $form->passwordFieldGroup($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		
		<?php echo $form->textFieldGroup($model,'email',array('size'=>60,'maxlength'=>128)); ?>

		<?php echo $form->dropdownlistGroup($model,'status', array( 'widgetOptions'=> array( 'data'=>array("0"=>"Inactivo","1"=>"Activo")))); ?>
               
      <?php echo $form->fileFieldGroup($model, 'photo'); ?>
                

		<br><br>
		<?php $this->widget('booster.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Guardar', 'context'=>'primary')); ?>


<?php $this->endWidget(); ?>
