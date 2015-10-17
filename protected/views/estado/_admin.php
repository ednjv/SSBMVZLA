<?php $this->widget('booster.widgets.TbGridView', array(
	'id'=>'estado-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate'=>'afterUpdate',
	'columns'=>array(
		'id',
		'nombre',
		array(
			'name'=>'id_pais',
			'value'=>'CHtml::image(Yii::app()->baseUrl."/images/".$data->idPais->imagen, "", array("width"=>"40"))
				 . " " . $data->idPais->nombre',
			'type'=>'raw',
			'filter'=>CHtml::activeDropDownList($model, 'id_pais', $selectPaises, array('empty'=>''))
		),
		array(
			'template'=>'{update}',
			'class'=>'booster.widgets.TbButtonColumn',
		),
	)
)); ?>

<script>

function afterUpdate(){
	instalarSelect2('Estado_id_pais', 'País', true);
}

$(document).ready(function()
{
	instalarSelect2('Estado_id_pais', 'País', true);
});

</script>