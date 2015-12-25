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
		$selectTorneos = Torneo::model()->selectTorneos();
		$selectJugadores = Jugador::model()->selectJugadores();
		$peticion = null;
		$listaJugadores = "";
		$listaPartidos = "";
		$lengthResultados = null;
		if(isset($_POST['Api']) && !isset($_POST['ListaJugadorApi']) && !isset($_POST['ResultadoPvP'])){
			$i = 0;
			$apiForm = $_POST['Api'];
			$idTorneo = $apiForm['idTorneo'];
			$peticionParticipantes = ApiChallonge::getTorneoParticipantes($idTorneo);
			$jsonParticipantes = json_decode($peticionParticipantes, true);
			$listaJugadores .= '<h4>' . $idTorneo . '<input type="hidden" value="' . $idTorneo . '" name="idTorneo"/></h4>';
			foreach($jsonParticipantes as $key => $value){
				$participant = $value['participant'];
				$idParticipante = $participant['id'];
				$nickParticipante = $participant['name'];
				$rankParticipante = $participant['final_rank'];
				$jugadorLocal = '';
				$busqJugadorVzla = Jugador::model()->find('nick LIKE :nick', array(':nick'=>$nickParticipante));
				if($busqJugadorVzla != null){
					$jugadorLocal = $busqJugadorVzla->id;
				}
				$arrayJugadorApi = array($idParticipante=>$nickParticipante);
				$listaJugadores .= '<div class="row-fluid">';
				$listaJugadores .= 
					'<div class="col-md-1">'. $rankParticipante. ') </div>'
					. '<div class="col-md-3">'
					. Chtml::dropDownList('ListaJugadorApi['.$i.']', $idParticipante, $arrayJugadorApi, array('class'=>'listaJugador'))
					. '<input type="hidden" name="ListaJugadorLocal[posicionJugador][' . $i . ']" value="' . $rankParticipante . '"/>'
					. '</div>'
					. '<div class="col-md-1"> => </div>'
					. '<div class="col-md-7">'
					. Chtml::dropDownList('ListaJugadorLocal['.$i.']', $jugadorLocal, $selectJugadores, array('class'=>'listaJugador'))
					. '</div><br/>';
				$listaJugadores .= '</div>';
				$i++;
			}
			$listaJugadores .= CHtml::dropDownList('ListaJugadorLocal[idTorneoVzla]', '', $selectTorneos, array('empty'=>''));
		}else{
			if(isset($_POST['ListaJugadorApi'], $_POST['ListaJugadorLocal'])){
				$peticionPartidos = ApiChallonge::getPartidoTorneo($_POST['idTorneo']);
				$lengthJugadores = count($_POST['ListaJugadorApi']);
				for($i=0; $i < $lengthJugadores; $i++){
					$jugadorApi = $_POST['ListaJugadorApi'][$i];
					$jugadorLocal = $_POST['ListaJugadorLocal'][$i];
					$idTorneoLocal = $_POST['ListaJugadorLocal']['idTorneoVzla'];
					$posicionJugadorLocal = $_POST['ListaJugadorLocal']['posicionJugador'][$i];
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
					$listaPartidos .= 
						'<div>'
						. $jugadorVzla1->nick
						. ' Vs.'
						. $jugadorVzla2->nick
						. ': <span class="green">' . $ganadorVzla->nick . '</span>'
						. '<input type="hidden" name="ResultadoPvP[jugador1][' . $i . ']" value="' . $player1Id . '"/>'
						. '<input type="hidden" name="ResultadoPvP[jugador2][' . $i . ']" value="' . $player2Id . '"/>'
						. '<input type="hidden" name="ResultadoPvP[jugadorGanador][' . $i . ']" value="' . $winnerId . '"/>'
						. '<input type="hidden" name="ResultadoPvP[ronda][' . $i . ']" value="' . $ronda . '"/>'
						. '<input type="hidden" name="ResultadoPvP[numeroRonda][' . $i . ']" value="' . $numeroRonda . '"/>'
						. '</div><br/>';
					$i++;
				}
				$listaPartidos .=
					Chtml::label('ID Torneo SSBMVZLA', 'ResultadoPvP_idTorneoVzla')
					. '<br/>'
					. CHtml::dropDownList('ResultadoPvP[idTorneoVzla]', '', $selectTorneos, array('empty'=>''));
			}else{
				if(isset($_POST['ResultadoPvP'])){
					$lengthResultados = count($_POST['ResultadoPvP']['jugador1']);
					for($i=0; $i < $lengthResultados; $i++){
						$jugador1 = $_POST['ResultadoPvP']['jugador1'][$i];
						$jugador2 = $_POST['ResultadoPvP']['jugador2'][$i];
						$jugadorGanador = $_POST['ResultadoPvP']['jugadorGanador'][$i];
						$ronda = $_POST['ResultadoPvP']['ronda'][$i];
						$numeroRonda = $_POST['ResultadoPvP']['numeroRonda'][$i];
						$idTorneo = $_POST['ResultadoPvP']['idTorneoVzla'];
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
		}
		$this->render('index', array(
			'peticion'=>$peticion,
			'listaJugadores'=>$listaJugadores,
			'listaPartidos'=>$listaPartidos,
			'lengthResultados'=>$lengthResultados
		));
	}
}
?>