
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'updatePassword-form',
)); 
$user = Yii::app()->getUser(); 
?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios</p>
        
<?php if(!$user->checkAccess('Admin')) { ?>        
		<?php echo $form->passwordFieldGroup($model,'oldPassword'); ?>
<?php } ?>

		<?php echo $form->passwordFieldGroup($model,'password',array('size'=>20,'maxlength'=>20)); ?>

		<?php echo $form->passwordFieldGroup($model,'verifyPassword',array('size'=>60,'maxlength'=>128)); ?>
<br><br>
		<?php $this->widget('booster.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Guardar', 'context'=>'primary')); ?>


<?php $this->endWidget(); ?>

