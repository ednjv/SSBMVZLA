<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'pais-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'nombre',
		array(
			'name'=>'imagen',
			'value'=>'chtml::image(Yii::app()->baseUrl."/images/".$data->imagen,"",array("width"=>"40"))',
			'type'=>'raw'
		),
array(
'template'=>'{update}',
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
