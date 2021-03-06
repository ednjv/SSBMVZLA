<div class="col-md-6 col-xs-12">
	<?php
    $this->widget('booster.widgets.TbGridView',array(
      'id' => 'torneo-grid',
      'type' => 'striped',
      'dataProvider' => $model->search(),
      'selectionChanged' => 'GetPosiciones',
      'afterAjaxUpdate' => 'CargarClickDetalleTorneo',
      'selectableRows' => 1,
      'filter' => $model,
      'columns' => array(
        array(
          'name' => 'nombre',
          'type' => 'raw',
          'value' => 'CHtml::link($data->nombre, "", array("class" => "verImagenTorneo", "idTorneo" => $data->id, "style" => "cursor:pointer;"))'
        ),
        array(
          'name' => 'estadoAux',
          'value' => '$data->idEstado->nombre'
        ),
        array(
          'name' => 'fecha',
          'value' => 'strftime("%d/%m/%Y", strtotime($data->fecha))'
        ),
      ),
      'htmlOptions' => array(
        'style' => 'overflow:auto;'
      )
    ));
  ?>
</div>
<div class="col-md-6 col-xs-12">
  <div id="resultadoBusqueda"></div>
</div>

<div id="modalGaleria" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tournament</h4>
      </div>
      <div id="galeriaImagenes" class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

	function GetPosiciones(id){
		var idTorneo = $.fn.yiiGridView.getSelection(id);
    var hasSelection = idTorneo.length;
		if (hasSelection) {
			$.fancybox.showLoading();
			$.ajax({
				type: 'GET',
				url: '<?php echo Yii::app()->baseUrl . "/index.php/jugadorPosicionTorneo/ObtenerPosicionesTorneo"; ?>',
				data: {idTorneo: idTorneo[0], ajax: 'listViewPosiciones'},
				success: function(datos) {
					$.fancybox.hideLoading();
					$('#resultadoBusqueda').html(datos);
					CargarClickDetalleJugador();
				}
			});
		}
	}

	function CargarClickDetalleJugador(){
		$(".detalleJugadorPvp").click(function() {
			$.fancybox.showLoading();
			var idJugador = $(this).attr('idJugador');
			var idTorneo = $(this).attr('idTorneo');
			$.ajax({
				type: 'GET',
				url: '<?php echo Yii::app()->baseUrl . "/index.php/pvpSet/ObtenerPvpsJugadorTorneo"; ?>',
				data: {idJugador: idJugador,idTorneo: idTorneo, ajax: 'listViewPvps'},
				success: function(datos) {
					$.fancybox.hideLoading();
					$('#resultadoPvpJugadorTorneo').html(datos);
				}
			});
		});
	}

	function CargarClickDetalleTorneo() {
		$('.verImagenTorneo').click(function() {
			$.fancybox.showLoading();
			var idTorneo = $(this).attr('idTorneo');
			$.ajax({
				type: 'GET',
				url: '<?php echo Yii::app()->baseUrl . "/index.php/torneoImagen/VerImagenes"; ?>',
				data:{idTorneo: idTorneo},
				success: function(datos) {
					$.fancybox.hideLoading();
					$('#galeriaImagenes').html(datos);
					$('#modalGaleria').modal('show')
				}
			});
		});
	}

	$(document).ready(function(){
		new CargarClickDetalleTorneo();
	});

</script>


<style type="text/css">
  #resultadoBusqueda {
    margin-top: 36px;
  }
</style>
