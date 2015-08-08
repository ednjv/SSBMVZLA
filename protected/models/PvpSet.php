<?php

/**
 * This is the model class for table "pvp_set".
 *
 * The followings are the available columns in table 'pvp_set':
 * @property integer $id
 * @property integer $id_jugador_1
 * @property integer $id_jugador_2
 * @property integer $id_jugador_ganador
 * @property integer $id_torneo
 * @property string $ronda
 *
 * The followings are the available model relations:
 * @property Jugador $idJugador1
 * @property Jugador $idJugador2
 * @property Jugador $idJugadorGanador
 * @property Torneo $idTorneo
 */
class PvpSet extends CActiveRecord
{
	public $jugador1Aux;
	public $jugador2Aux;
	public $jugadorGanadorAux;
	public $torneoAux;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pvp_set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo, ronda, elo_jugador_1, elo_jugador_2, numero_ronda', 'required'),
			array('id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo', 'numerical', 'integerOnly'=>true),
			array('ronda', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo, ronda, elo_jugador_1, elo_jugador_2, numero_ronda, jugador1Aux, jugador2Aux, jugadorGanadorAux, torneoAux', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idJugador1' => array(self::BELONGS_TO, 'Jugador', 'id_jugador_1'),
			'idJugador2' => array(self::BELONGS_TO, 'Jugador', 'id_jugador_2'),
			'idJugadorGanador' => array(self::BELONGS_TO, 'Jugador', 'id_jugador_ganador'),
			'idTorneo' => array(self::BELONGS_TO, 'Torneo', 'id_torneo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_jugador_1' => 'Id Jugador 1',
			'id_jugador_2' => 'Id Jugador 2',
			'id_jugador_ganador' => 'Id Jugador Ganador',
			'id_torneo' => 'Id Torneo',
			'ronda' => 'Ronda',
			'elo_jugador_1' => 'Elo Jugador 1',
			'elo_jugador_2' => 'Elo Jugador 2',
			'numero_ronda' => 'Numero Ronda',
			'jugador1Aux' => 'Jugador 1',
			'jugador2Aux' => 'Jugador 2',
			'jugadorGanadorAux' => 'Jugador Ganador',
			'torneoAux' => 'Torneo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_jugador_1',$this->id_jugador_1);
		$criteria->compare('id_jugador_2',$this->id_jugador_2);
		$criteria->compare('id_jugador_ganador',$this->id_jugador_ganador);
		$criteria->compare('id_torneo',$this->id_torneo);
		$criteria->compare('ronda',$this->ronda,true);
		$criteria->compare('elo_jugador_1',$this->elo_jugador_1);
		$criteria->compare('elo_jugador_2',$this->elo_jugador_2);
		$criteria->compare('numero_ronda',$this->numero_ronda);
		$criteria->compare('idJugador1.nick',$this->jugador1Aux,true);
		$criteria->compare('idJugador2.nick',$this->jugador2Aux,true);
		$criteria->compare('idJugadorGanador.nick',$this->jugadorGanadorAux,true);
		$criteria->compare('idTorneo.nombre',$this->torneoAux,true);
		$criteria->with=array('idJugador1','idJugador2','idJugadorGanador','idTorneo');

		$sort=new CSort;
		$sort->attributes=array(
			'jugador1Aux'=>array(
				'asc'=>'idJugador1.nick',
				'desc'=>'idJugador1.nick desc',
			),
			'jugador2Aux'=>array(
				'asc'=>'idJugador2.nick',
				'desc'=>'idJugador2.nick desc',
			),
			'jugadorGanadorAux'=>array(
				'asc'=>'idJugadorGanador.nick',
				'desc'=>'idJugadorGanador.nick desc',
			),
			'torneoAux'=>array(
				'asc'=>'idTorneo.nombre',
				'desc'=>'idTorneo.nombre desc',
			),
			'*',
		);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PvpSet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Función que calcula la puntuación ELO de un jugador
	 * Basada en las siguientes fórmula:
	 * E1=1/(1+10^((eloJugador2-eloJugador1)/400))
	 * R1=eloJugador1+K*(S-E1)
	 * Donde:
	 * 		E1, es el puntaje esperado del puntaje ELO del jugador 1 en relacion al puntaje ELO del jugador 2
	 * 		eloJugador1, es el puntaje ELO del jugador 1
	 * 		eloJugador2, es el puntaje ELO del jugador 2
	 * 		R1, es el nuevo puntaje ELO del jugador 1
	 * 		K, es la constante de ajuste del puntaje
	 * 		S, es el resultado del enfrentamiento, 0=Perdió, 1=Ganó
	 * Fuente: https://es.wikipedia.org/wiki/Sistema_de_puntuación_Elo
	 * @param integer $elo1, puntaje ELO del jugador 1
	 * @param integer $elo2, puntaje ELO del jugador 2
	 * @param integer $S, resultado del enfrentamiento, 0=Perdió, 1=Ganó
	 * @param integer $K, constante de ajuste del puntaje
	*/
	public function calcularElo($elo1,$elo2,$S,$K=16){
		$esperado=1/(1+(pow(10,($elo2-$elo1)/400)));
		$nuevoRating=$elo1+$K*($S-$esperado);
		return $nuevoRating;
	}

	/*
		1. Crear el set con elos=0
		2. Verificar cuantos sets tienen las personas
		3. Verificar si alguno no tiene ranking
		4. Si uno tiene ranking y el otro no, no modificar los datos del ranking del que tiene y pasar al que no tiene al rank_temporal
		5. Si el que no tiene ranking ya tiene mas de 3 sets verificar pasarlo al ranking pero sin modificar los datos de su adversario
		3. Si tienen hacer los calculos en base a su ranking actual (fecha asc numero ronda asc)
		4. Si no tienen, crearlos con 1000 puntos en el jugador_rank_temp
	*/
	public function calcularRanking($model){
		$hasRank1=false;
		$hasRank2=false;
		$hasTempRank1=false;
		$hasTempRank2=false;
		$findRanking1=JugadorRanking::model()->find(array(
			'condition'=>'id_jugador=:id_jugador1',
			'params'=>array(':id_jugador1'=>$model->id_jugador_1),
			'with'=>array('idPvpSet'=>array('with'=>array('idTorneo'))),
			'order'=>'idTorneo.fecha, numero_ronda',
		));
		$findRanking2=JugadorRanking::model()->find(array(
			'condition'=>'id_jugador=:id_jugador2',
			'params'=>array(':id_jugador2'=>$model->id_jugador_2),
			'with'=>array('idPvpSet'=>array('with'=>array('idTorneo'))),
			'order'=>'idTorneo.fecha, numero_ronda',
		));
		if($findRanking1==null){
			$findRankingTemp1=JugadorRankTemp::model()->find(array(
				'condition'=>'id_jugador=:id_jugador1',
				'params'=>array(':id_jugador1'=>$model->id_jugador_1),
				'with'=>array('idPvpSet'=>array('with'=>array('idTorneo'))),
				'order'=>'idTorneo.fecha, numero_ronda',
			));
			if($findRankingTemp1==null){
				$newTempRank1=new JugadorRankTemp;
				$newTempRank1->id_pvp_set=$model->id;
				$newTempRank1->id_jugador=$model->id_jugador_1;
				$newTempRank1->puntos=1000;
				$newTempRank1->save();
			}else{
				$count1=JugadorRankTemp::model()->count(array(
					'condition'=>'id_jugador=:id_jugador1',
					'params'=>array(':id_jugador1'=>$model->id_jugador_1)
				));
				$hasTempRank1=true;
			}
		}else{
			$hasRank1=true;
		}
		if($findRanking2==null){
			$findRankingTemp2=JugadorRankTemp::model()->find(array(
				'condition'=>'id_jugador=:id_jugador2',
				'params'=>array(':id_jugador2'=>$model->id_jugador_2),
				'with'=>array('idPvpSet'=>array('with'=>array('idTorneo'))),
				'order'=>'idTorneo.fecha, numero_ronda',
			));
			if($findRankingTemp2==null){
				$newTempRank2=new JugadorRankTemp;
				$newTempRank2->id_pvp_set=$model->id;
				$newTempRank2->id_jugador=$model->id_jugador_2;
				$newTempRank2->puntos=1000;
				$newTempRank2->save();
			}else{
				$count2=JugadorRankTemp::model()->count(array(
					'condition'=>'id_jugador=:id_jugador2',
					'params'=>array(':id_jugador2'=>$model->id_jugador_2)
				));
				$hasTempRank2=true;
			}
		}else{
			$hasRank2=true;
		}
		switch(true){
			case $hasRank1==true && $hasRank2==true:
				PvpSet::model()->crearRank($model,$findRanking1->puntos,$findRanking2->puntos,"JugadorRanking",true,true);
				break;
			case $hasRank1==true && $hasRank2==false:
				if($hasTempRank2==true){
					if($count2>4){
						PvpSet::model()->crearRank($model,$findRanking1->puntos,$findRankingTemp2->puntos,"JugadorRanking",false,true);	
					}else{
						PvpSet::model()->crearRank($model,$findRanking1->puntos,$findRankingTemp2->puntos,"JugadorRankTemp",false,true);	
					}
				}else{
					PvpSet::model()->crearRank($model,$findRanking1->puntos,1000,"JugadorRankTemp",false,true);
				}
				break;
			case $hasRank1==false && $hasRank2==true:
				if($hasTempRank1==true){
					if($count1>4){
						PvpSet::model()->crearRank($model,$findRankingTemp1->puntos,$findRanking2->puntos,"JugadorRanking",true,false);
					}else{
						PvpSet::model()->crearRank($model,$findRankingTemp1->puntos,$findRanking2->puntos,"JugadorRankTemp",true,false);
					}
				}else{
					PvpSet::model()->crearRank($model,1000,$findRanking2->puntos,"JugadorRankTemp",true,false);
				}
				break;
			case $hasRank1==false && $hasRank2==false:
				PvpSet::model()->crearRank($model,1000,1000,"JugadorRankTemp",true,true);
				break;
		}
	}

	public function crearRank($model,$puntosJug1,$puntosJug2,$modelRankName,$save1,$save2){
		$model->elo_jugador_1=$puntosJug1;
		$model->elo_jugador_2=$puntosJug2;
		$model->save();
		if($model->id_jugador_1!=$model->id_jugador_ganador){
			$res1=0;
			$res2=1;
		}else{
			$res1=1;
			$res2=0;
		}
		if($save1==true){
			$nuevoElo1=PvpSet::model()->calcularElo($puntosJug1,$puntosJug2,$res1);
			$ranking1=new $modelRankName;
			$ranking1->id_jugador=$model->id_jugador_1;
			$ranking1->id_pvp_set=$model->id;
			$ranking1->puntos=$nuevoElo1;
			$ranking1->save();
		}
		if($save2==true){
			$nuevoElo2=PvpSet::model()->calcularElo($puntosJug2,$puntosJug1,$res2);
			$ranking2=new $modelRankName;
			$ranking2->id_jugador=$model->id_jugador_2;
			$ranking2->id_pvp_set=$model->id;
			$ranking2->puntos=$nuevoElo2;
			$ranking2->save();
		}
	}
}
