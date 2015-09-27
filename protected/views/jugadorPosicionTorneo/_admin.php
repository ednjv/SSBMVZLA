<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'jugador-posicion-torneo-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'id_jugador',
		'id_torneo',
		'posicion',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
