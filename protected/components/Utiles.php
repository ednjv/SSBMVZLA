<?php
error_reporting(1);
class Utiles{
	public function listDataExtJson($model, $field, $desc = array(), $separator="/", $condition = "") {
		$data = $model::model()->findAll($condition);
		if($data){
			foreach($data as $n => $submodel){
				$value = CHtml::value($submodel, $field);
				$listData[$n][id] = $value;
				$i=0;
				foreach ($desc as $valor) {
					if(count($desc)-1==$i){
						$listData[$n][text] .= CHtml::value($submodel, $valor);
					}else{
						$listData[$n][text] .= CHtml::value($submodel, $valor) . $separator;
					}
					$i++;
				}
			}
		}else{
			$listData = array();
		}
		$aux = $listData;
		return json_encode($aux);
	}
}
?>
