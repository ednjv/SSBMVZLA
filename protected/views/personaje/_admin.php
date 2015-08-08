<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'personaje-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'nombre',
		array(
			'name'=>'imagen',
			'value'=>'chtml::image(Yii::app()->baseUrl."/images/".$data->imagen,"",array("width"=>"24"))',
			'type'=>'raw'
		),
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
