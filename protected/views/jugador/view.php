<?php

$menu=array(
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
    <div class='col-md-6 col-xs-12'>
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
                /*
		        array(
		            'name'=>'paisAux',
		            'value'=>chtml::image(Yii::app()->baseUrl."/images/".$model->idEstado->idPais->imagen,"",array("width"=>"40")),
		            'type'=>'raw'
		        ),
                */
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
                    'name'=>'winrateAux',
                    'value'=>$model->getWinRate()." %",
                ),
		),
		)); ?>
        <div id="todosSets">
            <h4>TORNEOS RECIENTES</h4>
            <?php $this->widget('booster.widgets.TbListView', array(
                'id'=>'listViewTorneos',
                'dataProvider'=>$ultimosTorneos,
                'itemView'=>'//layouts/_posicionesTorneo',
                'viewData'=>array(
                    'model'=>$model,
                    'view'=>"view",
                ),
            )); ?>
            <div id="modalGaleria" class="modal fade">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Torneo</h4>
                  </div>
                  <div id="galeriaImagenes" class="modal-body">
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            
            <h4>HISTORIA DE SETS</h4>
            <?php echo $countTorneos." torneos, ".count($countSets)." sets"; ?>
            <?php $this->widget('booster.widgets.TbListView', array(
                'dataProvider'=>$todosSets,
                'itemView'=>'//layouts/_historiaTorneos',
                'viewData'=>array(
                    'model'=>$model
                ),
                'summaryText'=>''
            )); ?>
        </div>
	</div>
	<div class='col-md-6 col-xs-12'>
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
        minimumInputLength: 1,
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
            type:'GET',
            url: "<?php echo Yii::app()->baseUrl.'/index.php/jugador/CompararJugador'; ?>",
            data:{jugadorActual:jugadorActual,jugadorComparar:jugadorComparar,ajax:'listViewVsJugador'},
            success: function(data){
                $("#result").html(data);
            }
        });
    }
});

$(".verImagenTorneo").click(function(){
    var idTorneo=$(this).attr('idTorneo');
    $.ajax({
        type:'GET',
        url: "<?php echo Yii::app()->baseUrl.'/index.php/torneoImagen/VerImagenes'; ?>",
        data:{idTorneo:idTorneo},
        success: function(datos){
            $("#galeriaImagenes").html(datos);
            $("#modalGaleria").modal('show')
        }
    });
});
</script>