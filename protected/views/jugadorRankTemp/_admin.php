<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'jugador-rank-temp-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'id_jugador',
		'id_pvp_set',
		'puntos',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
