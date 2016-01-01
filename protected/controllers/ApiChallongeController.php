<?php

class ApiChallongeController extends Controller
{
	/**
	 * @var string the default action for the controller.
	 */
	public $defaultAction='Index';

	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column1';

	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
			'postOnly + delete' // we only allow deletion via POST request
		);
	}

	public function actionIndex()
	{
		$peticion = null;
		$listaJugadores = '';
		$listaPartidos = '';
		$lengthResultados = null;
		if(isset($_POST['Api']) && !isset($_POST['ListaJugadorApi']) && !isset($_POST['ResultadoPvP'])){
			$this->procesarListaJugadores($_POST['Api'], $listaJugadores);
		}else{
			if(isset($_POST['ListaJugadorApi'], $_POST['ListaJugadorLocal'], $_POST['ApiTorneo'])){
				$this->procesarListaPartidos($_POST['ListaJugadorApi'], $_POST['ListaJugadorLocal'], $_POST['ApiTorneo'], $listaPartidos);
			}else{
				if(isset($_POST['ResultadoPvP'])){
					$this->procesarResultados($_POST['ResultadoPvP'], $lengthResultados);
				}
			}
		}
		$this->render('index', array(
			'peticion'=>$peticion,
			'listaJugadores'=>$listaJugadores,
			'listaPartidos'=>$listaPartidos,
			'lengthResultados'=>$lengthResultados
		));
	}

	private function procesarListaJugadores($apiForm, &$listaJugadores)
	{
		$selectJugadores = Jugador::model()->selectJugadores();
		$selectTorneos = Torneo::model()->selectTorneos();
		$idTorneo = $apiForm['idTorneo'];
		$peticionParticipantes = ApiChallonge::getTorneoParticipantes($idTorneo);
		$jsonParticipantes = json_decode($peticionParticipantes, true);
		$listaJugadores = $this->renderPartial('_listaJugadores', array(
			'idTorneo'=>$idTorneo,
			'jsonParticipantes'=>$jsonParticipantes,
			'selectJugadores'=>$selectJugadores,
			'selectTorneos'=>$selectTorneos
		), true, false);
	}

	private function procesarListaPartidos($postJugadorApi, $postJugadorLocal, $postTorneo, &$listaPartidos)
	{
		$selectTorneos = Torneo::model()->selectTorneos();
		$peticionPartidos = ApiChallonge::getPartidoTorneo($postTorneo['idTorneo']);
		$lengthJugadores = count($postJugadorApi);
		for($i=0; $i < $lengthJugadores; $i++){
			$jugadorApi = $postJugadorApi[$i];
			$jugadorLocal = $postJugadorLocal['jugadorId'][$i];
			$idTorneoLocal = $postJugadorLocal['idTorneoVzla'];
			$posicionJugadorLocal = $postJugadorLocal['posicionJugador'][$i];
			$peticionPartidos = str_replace($jugadorApi, $jugadorLocal, $peticionPartidos);
			$posicionJugador = new JugadorPosicionTorneo;
			$posicionJugador->id_jugador = $jugadorLocal;
			$posicionJugador->id_torneo = $idTorneoLocal;
			$posicionJugador->posicion = $posicionJugadorLocal;
			$posicionJugador->save();
		}
		$jsonPartidos = json_decode($peticionPartidos, true);
		$i = 0;
		foreach($jsonPartidos as $key => $value){
			$match = $value['match'];
			$player1Id = $match['player1_id'];
			$player2Id = $match['player2_id'];
			$winnerId = $match['winner_id'];
			$ronda = $match['identifier'];
			$numeroRonda = $match['round'];
			$jugadorVzla1 = Jugador::model()->findByPk($player1Id);
			$jugadorVzla2 = Jugador::model()->findByPk($player2Id);
			$ganadorVzla = Jugador::model()->findByPk($winnerId);
			$listaPartidos .= $this->renderPartial('_listaPartidos', array(
				'jsonPartidos'=>$jsonPartidos,
				'player1Id'=>$player1Id,
				'player2Id'=>$player2Id,
				'winnerId'=>$winnerId,
				'ronda'=>$ronda,
				'numeroRonda'=>$numeroRonda,
				'jugadorVzla1'=>$jugadorVzla1,
				'jugadorVzla2'=>$jugadorVzla2,
				'ganadorVzla'=>$ganadorVzla,
				'i'=>$i
			), true, false);
			$i++;
		}
		$listaPartidos .=
			Chtml::label('ID Torneo SSBMVZLA', 'ResultadoPvP_idTorneoVzla')
			. '<br/>'
			. CHtml::dropDownList('ResultadoPvP[idTorneoVzla]', '', $selectTorneos, array('empty'=>''))
			. '<br/>';
	}

	private function procesarResultados($postResultados, &$lengthResultados)
	{
		$lengthResultados = count($postResultados['jugador1']);
		for($i=0; $i < $lengthResultados; $i++){
			$jugador1 = $postResultados['jugador1'][$i];
			$jugador2 = $postResultados['jugador2'][$i];
			$jugadorGanador = $postResultados['jugadorGanador'][$i];
			$ronda = $postResultados['ronda'][$i];
			$numeroRonda = $postResultados['numeroRonda'][$i];
			$idTorneo = $postResultados['idTorneoVzla'];
			$modelPvpSet = new PvPSet;
			$modelPvpSet->id_jugador_1 = $jugador1;
			$modelPvpSet->id_jugador_2 = $jugador2;
			$modelPvpSet->id_jugador_ganador = $jugadorGanador;
			$modelPvpSet->id_torneo = $idTorneo;
			$modelPvpSet->ronda = $ronda;
			$modelPvpSet->numero_ronda = $numeroRonda;
			$modelPvpSet->elo_jugador_1 = 0;
			$modelPvpSet->elo_jugador_2 = 0;
			$modelPvpSet->nuevo_elo_1 = 0;
			$modelPvpSet->nuevo_elo_2 = 0;
			$modelPvpSet->save();
		}
	}
}
?>