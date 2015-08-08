<?php

$menu=array(
array('label'=>'Nuevo registro', 'buttonType'=>'link', 'icon'=>'plus', 'url'=>array('create')),
array('label'=>'Modificar', 'icon'=>'pencil','url'=>array('update','id'=>$model->id)),
array('label'=>'Eliminar','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro que desea borrar este elemento?')),
array('label'=>'Administrar', 'buttonType'=>'link', 'icon'=>'th-list', 'url'=>array('admin')),
);
?>


<?php $this->beginWidget('booster.widgets.TbPanel', array(
	    'title' => 'Detalles',
    	'headerIcon' => 'eye-open',
    	'headerHtmlOptions'=>array('style'=>'padding-bottom:5px;'),
    	'headerButtons' => array(
            array(
                'class' => 'booster.widgets.TbButtonGroup',
                'htmlOptions'=>array('style'=>'margin-top:-5px;'),
                'size' => 'small',
                'buttons'=>array(
                array('label'=>'Operaciones', 'icon'=>'cog','visible'=>Yii::app()->getUser()->checkAccess('Admin'),
                    'items'=>$menu),
                ),
            ),
        ),
        ));
?>

<div class='row-fluid'>
    <div class='col-md-6'>
		<?php $this->widget('booster.widgets.TbDetailView',array(
		'data'=>$model,
		'attributes'=>array(
				'primer_nombre',
				'primer_apellido',
				'nick',
		        array(
		            'name'=>'estadoAux',
		            'value'=>$model->idEstado->nombre,
		        ),
		        array(
		            'name'=>'paisAux',
		            'value'=>chtml::image(Yii::app()->baseUrl."/images/".$model->idEstado->idPais->imagen,"",array("width"=>"40")),
		            'type'=>'raw'
		        ),
		        array(
		            'name'=>'personajes',
		            'value'=>$model->getPersonajes($model->id),
		            'type'=>'raw',
		        ),
		        array(
		            'name'=>'record',
		            'value'=>$model->getRecord($model->id),
		        ),
                array(
                    'name'=>'WinRate',
                    'value'=>$model->getWinRate()." %",
                ),
		),
		)); ?>
        <div id="todosSets">
            <h4>HISTORIA DE SETS</h4>
            <?php echo $countTorneos." torneos, ".count($todosSets)." sets"; ?>
            <ul style="width:70%; padding-left: 0px;">
            <?php
                foreach($todosSets as $set){
            ?>
                <li style='padding:10px 15px; display:block; border:1px solid gray;'>
                    <span style='float:left;'>
                        <?php
                            if($set->id_jugador_1==$model->id) {
                                echo "vs. ".$set->idJugador2->nick;
                            }else{
                                echo "vs. ".$set->idJugador1->nick;
                            }
                        ?>
                    </span>    
                    <span style='float:right; background-color:#aab2bd; border-radius:10px; color:#fff; display:inline-block; font-size:12px; font-weight:700; line-height: 1; min-width:10px; padding:3px 7px; text-align:center; vertical-align:baseline; white-space:nowrap;'>
                        <?php echo $set->ronda; ?>
                    </span>
                    <span style="display:inline-block; float:right; font-weight:bold; margin-right:10px;">
                        <?php
                            if($set->id_jugador_ganador!=$model->id){
                                echo "L ";
                            }else{
                                echo "W";
                            }
                        ?>
                    </span>
                    <br>
                    <?php echo CHtml::image(Yii::app()->baseUrl."/images/".$set->idTorneo->idEstado->idPais->imagen,"",array('width'=>'40')); ?>
                    <?php echo $set->idTorneo->nombre; ?>
                    <span style="float:right; font-size:14px;">
                        <?php echo strftime("%B %d, %Y",strtotime(str_replace("-", "/", $set->idTorneo->fecha))); ?>
                    </span>
                </li>
            <?php
                }
            ?>
            </ul>
        </div>
	</div>
	<div class='col-md-6'>
		<h2>PVP SET COUNT</h2>
		VS<input id="buscar_jugador" class="form-control" type="text" name="jugadorId">
		<br>        
		<div id="result"></div>
	</div>

<?php $this->endWidget();
?>


<script>
$("#buscar_jugador").select2({
        placeholder: "Nick",
        allowClear: true,
        minimumInputLength: 3,
        width: '50%',
        ajax: {
            url: '<?php echo Yii::app()->request->baseUrl; ?>/index.php/jugador/getJugador',
            dataType: 'json',
            data: function(term, page){
                return{
                    nick: term,
                };
            },
            results: function(data, page){
                return {results: data};
            },
            cache: true
        },
        formatResult: function(data){
            return data.text;
        },
        formatSelection: function(data){
            return data.text;
        }
}).on("select2-removed", function(e){
    $("#result").html("");
});

$("#buscar_jugador").change(function(){
    var jugadorComparar=$(this).val();
    if(jugadorComparar!=""){
        var jugadorActual="<?php echo $model->id; ?>";
        $.ajax({
            type:'POST',
            url: "<?php echo Yii::app()->baseUrl.'/index.php/jugador/CompararJugador'; ?>",
            data:{jugadorActual:jugadorActual,jugadorComparar:jugadorComparar},
            success: function(data){
                $("#result").html(data);
            }
        });
    }
});
</script>