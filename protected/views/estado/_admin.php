<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'estado-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'nombre',
		array(
			'name'=>'id_pais',
			'value'=>'chtml::image(Yii::app()->baseUrl."/images/".$data->idPais->imagen,"",array("width"=>"40"))',
			'type'=>'raw'
		),
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
