<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'torneo-imagen-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'id_torneo',
		'descripcion',
		'imagen',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
