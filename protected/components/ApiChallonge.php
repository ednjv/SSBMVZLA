<?php
/**
 * Clase para consumir las diferentes apis de challonge
 */
class ApiChallonge{
	const URL = "http://api.challonge.com/v1/";
	const KEY = "YourApiKeyHere";

	/**
	 * Obtiene todos los participantes de un torneo
	 * @param string $idTorneo identificador unico del torneo
	 * @return string en formato json de la respuesta
	 */
	public function getTorneoParticipantes($idTorneo){
		$url = ApiChallonge::getUrl() . "tournaments/" . $idTorneo . "/participants.json";
		$parametros = ApiChallonge::appendKey(null);
		return Yii::app()->curl->get($url, $parametros);
	}

	/**
	 * Obtiene todos los sets jugados en un torneo
	 * @param string $idTorneo identificador unico del torneo
	 * @return string en formato json de la respuesta
	 */
	public function getPartidoTorneo($idTorneo){
		$url = ApiChallonge::getUrl() . "tournaments/" . $idTorneo . "/matches.json";
		$parametros = ApiChallonge::appendKey(null);
		return Yii::app()->curl->get($url, $parametros);
	}

	/**
	 * Obtiene la descripcion completa de un jugador
	 * @param string $idTorneo identificador unico del torneo
	 * @param integer $idParticipante identificador unico del jugador
	 * @return string en formato json de la respuesta
	 */
	public function getParticipante($idTorneo, $idParticipante){
		$url = ApiChallonge::getUrl() . "tournaments/" . $idTorneo . "/participants/" . $idParticipante . ".json";
		$parametros = ApiChallonge::appendKey(null);
		return Yii::app()->curl->get($url, $parametros);
	}

	/**
	 * Añade la llave de la api como parametro para las peticiones
	 * @param  array $arrayParams parametros que seran enviados a la api
	 * @return array parametros con el nuevo parametro "api_key"
	 */
	private function appendKey($arrayParams){
		$arrayKey = array('api_key'=>ApiChallonge::getKey());
		if($arrayParams == null){
			return $arrayKey;
		}else{
			return $arrayParams += $arrayKey;
		}
	}

	public function getUrl(){
		return self::URL;
	}

	public function getKey(){
		return self::KEY;
	}
}

?>