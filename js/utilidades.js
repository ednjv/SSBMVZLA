/**
 * Instala un select2 a un select, debe estar inicializado el paquete de select2
 * @param idSelect atributo id del select sin el #
 * @param placeHolder texto a mostrar en el placeholder del select
 * @param formatters indica si al select2 se le añadirán los formatters personalizados (true o false)
*/
function instalarSelect2(idSelect, placeHolder, formatters){
	opciones={
		allowClear: true,
		width: '100%',
		placeholder: placeHolder
	}
	if(formatters==true){
		opciones['formatResult']=function(data){
			var backSlash='';
			if(location.href=='http://ssbmvenezuela.byethost11.com/SSBMVZLA/index.php'){
				backSlash='';
			}else{
				if(location.href!='http://ssbmvenezuela.byethost11.com/SSBMVZLA/'){
					backSlash='../../';
				}
			}
			var datos=data.text;
			var splitted=datos.split('|');
			var imagen='<img src="'+backSlash+'images/'+splitted[1]+'" width="24"/>';
			var descripcion=splitted[0];
			return imagen+' '+descripcion;
		};
		opciones['formatSelection']=function(data){
			var datos=data.text;
			var splitted=datos.split('|');
			var descripcion=splitted[0];
			return descripcion;
		};
	}
	$('#'+idSelect).select2(opciones);
}