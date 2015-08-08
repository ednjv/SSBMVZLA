<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'torneo-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'nombre',
		'id_estado',
		'fecha',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
