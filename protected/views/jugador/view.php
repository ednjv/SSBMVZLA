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
    <div class='col-md-4 col-xs-12'>
		<?php $this->renderPartial('_detallesJugador',array(
			'model'=>$model
		)); ?>
        <div id="pvpSet" class="panel panel-default">
            <div class="panel-heading">
                <h4>Recórd Vs</h4>
            </div>
            <div class="panel-body">
                VS<input id="buscar_jugador" class="form-control" type="text" name="jugadorId">
                <br>        
                <div id="result"></div>
            </div>
        </div>
    </div>
    <div class=" col-md-4 col-xs-12">
        <div id="torneosRecientes" class="panel panel-default">
            <div class="panel-heading">
                <h4>Torneos Recientes</h4>
            </div>
            <div class="panel-body">
                <?php $this->widget('booster.widgets.TbListView', array(
                    'id'=>'listViewTorneos',
                    'dataProvider'=>$ultimosTorneos,
                    'itemView'=>'//layouts/_posicionesTorneo',
                    'viewData'=>array(
                        'model'=>$model,
                        'view'=>"view",
                    ),
                )); ?>
            </div>
        </div>
    </div>
    <div class=" col-md-4 col-xs-12">
        <div id="historiaSets" class="panel panel-default">
            <div class="panel-heading">
                <h4>Histórico de Sets</h4>
            </div>
            <div class="panel-body">
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
    </div>
</div>
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

<?php $this->endWidget();
?>


<script>
$("#buscar_jugador").select2({
        placeholder: "Nick",
        allowClear: true,
        minimumInputLength: 1,
        width: '100%',
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
    $.fancybox.showLoading();
    var jugadorComparar=$(this).val();
    if(jugadorComparar!=""){
        var jugadorActual="<?php echo $model->id; ?>";
        $.ajax({
            type:'GET',
            url: "<?php echo Yii::app()->baseUrl.'/index.php/jugador/CompararJugador'; ?>",
            data:{jugadorActual:jugadorActual,jugadorComparar:jugadorComparar,ajax:'listViewVsJugador'},
            success: function(data){
                $.fancybox.hideLoading();
                $("#result").html(data);
            }
        });
    }
});

$(".verImagenTorneo").click(function(){
    $.fancybox.showLoading();
    var idTorneo=$(this).attr('idTorneo');
    $.ajax({
        type:'GET',
        url: "<?php echo Yii::app()->baseUrl.'/index.php/torneoImagen/VerImagenes'; ?>",
        data:{idTorneo:idTorneo},
        success: function(datos){
            $.fancybox.hideLoading();
            $("#galeriaImagenes").html(datos);
            $("#modalGaleria").modal('show')
        }
    });
});
</script>