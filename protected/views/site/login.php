<?php
$this->pageTitle=Yii::app()->name . ' - Inicio de Sesión';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="col-md-4 col-sm-6 col-sm-offset-3 col-md-offset-4">
            
    <?php $this->beginWidget('booster.widgets.TbPanel', array(
            'title' => false,
            'headerIcon' => 'lock',
            'contentHtmlOptions'=>array('style'=>'background:#F7F7F7;box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);')
    ) );?>
    <p align="center" style="font-size:25px;"><b><?php echo Yii::app()->name; ?></b></p>
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                            'id' => 'login-form',
            ));?> 
            <?php  echo $form->textFieldGroup($model, 'username'); ?>
            <?php  echo $form->passwordFieldGroup($model, 'password'); ?>
            <?php $this->widget('booster.widgets.TbButton',
                            array( 'buttonType' => 'submit', 'label' => 'Entrar', 'context' => 'primary', 'htmlOptions'=>array('class'=>'pull-right'))
                    );
                    $this->endWidget();
                    unset($form);
            ?>
    <?php $this->endWidget(); ?>
    
</div>
<style type="text/css">
    body, html {
        background-image: linear-gradient(rgb(104, 145, 162), #1E3747);
        background-repeat: no-repeat;
        height: 100%;
    }
    body {
        padding-top: 50px;
    }
</style>




