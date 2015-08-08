<?php
Yii::app()->clientScript->registerScript('search', "
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('user-grid', {
			data: $(this).serialize()
		});
return false;
});
");
?>


	<?php $this->widget('booster.widgets.TbGridView', array(
		'id'=>'user-grid',
		'filter'=>$model,
		'type' => 'striped condensed',
		'dataProvider'=>$model->search(),
		'template' => "{items}{pager}",
		'columns'=>array(
			'id',
			'cedula',
			array(
				'name' => 'username',
				'type'=>'raw',
				'value' => 'CHtml::link($data->username,array("user/view","id"=>$data->id))',
				),
			'email',
			'create_at',
			'lastvisit_at',
			array(
				'class'=>'booster.widgets.TbToggleColumn',
				'toggleAction'=>'user/toggle',
				'name' => 'status',
				'value'=> '$data->status',
				                  
				),
			),
			)); ?>
