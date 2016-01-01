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
 * @property integer $elo_jugador_1
 * @property integer $elo_jugador_2
 * @property integer $numero_ronda
 * @property integer $nuevo_elo_1
 * @property integer $nuevo_elo_2
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
			array('id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo, ronda, elo_jugador_1, elo_jugador_2, numero_ronda,, nuevo_elo_1, nuevo_elo_2', 'required'),
			array('id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo, elo_jugador_1, elo_jugador_2, numero_ronda, nuevo_elo_1, nuevo_elo_2', 'numerical', 'integerOnly'=>true),
			array('ronda', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo, ronda, elo_jugador_1, elo_jugador_2, numero_ronda, nuevo_elo_1, nuevo_elo_2, jugador1Aux, jugador2Aux, jugadorGanadorAux, torneoAux', 'safe', 'on'=>'search'),
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
			'nuevo_elo_1' => 'Nuevo Elo 1',
			'nuevo_elo_2' => 'Nuevo Elo 2',
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
		$criteria->compare('nuevo_elo_1',$this->nuevo_elo_1);
		$criteria->compare('nuevo_elo_2',$this->nuevo_elo_2);
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

	public function historiaTorneos($id){
		$criteria=new CDbCriteria;
		$criteria->condition="id_jugador_1=:id OR id_jugador_2=:id";
		$criteria->params=array(':id'=>$id);
		$criteria->with=array('idTorneo');
		$criteria->order='idTorneo.fecha desc, t.id desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>5,
			),
		));
	}

	public function historiaVs($jugadorActual, $jugadorComparar){
		$criteria=new CDbCriteria;
		$criteria->condition='(id_jugador_1=:jugadorActual OR id_jugador_2=:jugadorActual) AND (id_jugador_1=:jugadorComparar OR id_jugador_2=:jugadorComparar) AND (:jugadorComparar!=:jugadorActual)';
		$criteria->params=array(':jugadorActual'=>$jugadorActual,':jugadorComparar'=>$jugadorComparar);
		$criteria->with=array('idTorneo');
		$criteria->order='idTorneo.fecha desc, t.id desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>5,
			),
		));
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
	 * @param integer $S, resultado del enfrentamiento en relacion al jugador 1, 0=Perdió, 1=Ganó
	 * @param integer $K, constante de ajuste del puntaje
	*/
	public function calcularElo($elo1,$elo2,$S,$K){
		$esperado1=1/(1+(pow(10,($elo2-$elo1)/400)));
		$nuevoRating1=$elo1+$K*($S-$esperado1);
		return round($nuevoRating1);
	}

	/**
	 * Función que calcula los puntajes de los jugadores que se enfrentan
	 * @param object $model, modelo del PvPSet
	*/
	public function calcularRanking($model){
		$hasRank1=false;
		$hasRank2=false;
		$hasTempRank1=false;
		$hasTempRank2=false;
		$count1=0;
		$count2=0;
		$modelRank="JugadorRankTemp";
		$findRanking1=JugadorRankTemp::model()->find(array(
			'condition'=>'id_jugador=:id_jugador1 AND status=1',
			'params'=>array(':id_jugador1'=>$model->id_jugador_1),
		));
		if($findRanking1!=null){
			$count1=PvpSet::model()->count(array(
				'condition'=>'(id_jugador_1=:id_jugador1 OR id_jugador_2=:id_jugador1) AND (elo_jugador_1>0 OR elo_jugador_2>0)',
				'params'=>array(':id_jugador1'=>$model->id_jugador_1)
			));
			$hasRank1=true;
		}
		$findRanking2=JugadorRankTemp::model()->find(array(
			'condition'=>'id_jugador=:id_jugador2 AND status=1',
			'params'=>array(':id_jugador2'=>$model->id_jugador_2),
		));
		if($findRanking2!=null){
			$count2=PvpSet::model()->count(array(
				'condition'=>'(id_jugador_1=:id_jugador2 OR id_jugador_2=:id_jugador2) AND (elo_jugador_1>0 OR elo_jugador_2>0)',
				'params'=>array(':id_jugador2'=>$model->id_jugador_2)
			));
			$hasRank2=true;
		}
		switch(true){
			case $hasRank1==true && $hasRank2==true:
				PvpSet::model()->crearRank($model,$findRanking1->puntos,$findRanking2->puntos,$modelRank,$count1,$count2);
				break;
			case $hasRank1==true && $hasRank2==false:
				PvpSet::model()->crearRank($model,$findRanking1->puntos,2000,$modelRank,$count1,$count2);
				break;
			case $hasRank1==false && $hasRank2==true:
				PvpSet::model()->crearRank($model,2000,$findRanking2->puntos,$modelRank,$count1,$count2);
				break;
			case $hasRank1==false && $hasRank2==false:
				PvpSet::model()->crearRank($model,2000,2000,$modelRank,$count1,$count2);
				break;
		}
	}

	/**
	 * Función que genera los ranking de los jugadores
	 * @param object $model, modelo del PvPSet
	 * @param integer $puntosJug1, puntos del jugador 1
	 * @param integer $puntosJug2, puntos del jugador 2
	 * @param string $modelRankName, nombre del modelo a guardar
	 * @param integer $count1, cantidad de registros en el ranking del jugador 1
	 * @param integer $count2, cantidad de registros en el ranking del jugador 2
	*/
	public function crearRank($model,$puntosJug1,$puntosJug2,$modelRankName,$count1,$count2){
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
		if($count1<30){
			$K1=25;
		}else{
			if($puntosJug1<2300){
				$K1=25;
			}elseif($puntosJug1>=2300 && $puntosJug1<2400){
				$K1=15;
			}elseif($puntosJug1>=2400){
				$K1=10;
			}
		}
		$nuevoElo1=PvpSet::model()->calcularElo($puntosJug1,$puntosJug2,$res1,$K1);
		$ranking1=new $modelRankName;
		$ranking1->id_jugador=$model->id_jugador_1;
		$ranking1->puntos=$nuevoElo1;
		$ranking1->fecha=date('Y-m-d h:i:s');
		$ranking1->status=1;
		$ranking1->posicion=0;
		$ranking1->save();
		if($count2<30){
			$K2=25;
		}else{
			if($puntosJug2<2300){
				$K2=25;
			}elseif($puntosJug2>=2300 && $puntosJug2<2400){
				$K2=15;
			}elseif($puntosJug2>=2400){
				$K2=10;
			}
		}
		$nuevoElo2=PvpSet::model()->calcularElo($puntosJug2,$puntosJug1,$res2,$K2);
		$ranking2=new $modelRankName;
		$ranking2->id_jugador=$model->id_jugador_2;
		$ranking2->puntos=$nuevoElo2;
		$ranking2->fecha=date('Y-m-d h:i:s');
		$ranking2->status=1;
		$ranking2->posicion=0;
		$ranking2->save();
		$model->nuevo_elo_1=$nuevoElo1;
		$model->nuevo_elo_2=$nuevoElo2;
		$model->save();
	}

	public function chartSets($idJugador){
		$criteria=new CDbCriteria;
		$criteria->condition='(id_jugador_1=:idJug OR id_jugador_2=:idJug) AND (elo_jugador_1>0 OR elo_jugador_2>0)';
		$criteria->params=array(':idJug'=>$idJugador);
		$criteria->with=array('idTorneo');
		$criteria->order='idTorneo.fecha, numero_ronda';
		$criteria->limit=12;
		$countSets=PvpSet::model()->count($criteria);
		$offset=$countSets-12;
		if($countSets>=12){
			$criteria->offset=$offset;
		}
		$sets=PvpSet::model()->findAll($criteria);
		return $sets;
	}

	public function chartVsJugadores($model,$jugId){
		$vsJugadores=array();
		foreach($model as $set){
			if($set->idJugador1->id==$jugId){
				$diferencia=PvPSet::model()->chartFormat($set,$jugId);
				$vsJugadores[]=$set->idJugador2->nick."-".$set->idTorneo->nombre."-".$diferencia;
			}else{
				$diferencia=PvPSet::model()->chartFormat($set,$jugId);
				$vsJugadores[]=$set->idJugador1->nick."-".$set->idTorneo->nombre."-".$diferencia;
			}
		}
		return $vsJugadores;
	}

	public function chartPtsVs($model,$jugId){
		$ptsVs=array();
		foreach($model as $set){
			if($set->idJugador1->id==$jugId){
				$ptsVs[]=$set->nuevo_elo_1;
			}else{
				$ptsVs[]=$set->nuevo_elo_2;
			}
		}
		return array_map('intVal', $ptsVs);
	}

	public function chartFormat($model,$jugId){
		if($model->idJugador1->id==$jugId && $model->idJugadorGanador->id==$jugId){
			$diferencia="Ganó ";
			$diferencia.=$model->nuevo_elo_1-$model->elo_jugador_1;
		}else{
			if($model->idJugador2->id==$jugId && $model->idJugadorGanador->id==$jugId){
				$diferencia="Ganó ";
				$diferencia.=$model->nuevo_elo_2-$model->elo_jugador_2;
			}else{
				if($model->idJugador1->id==$jugId){
					$diferencia="Perdió ";
					$diferencia.=$model->elo_jugador_1-$model->nuevo_elo_1;
				}else{
					if($model->idJugador2->id==$jugId){
						$diferencia="Perdió ";
						$diferencia.=$model->elo_jugador_2-$model->nuevo_elo_2;
					}
				}
			}
		}
		$diferencia.=" pts";
		return $diferencia;
	}

	public function getPvpsJugador($condicion, $params=array(), $order="", $pagSize=5){
		$criteria=new CDbCriteria;
		$criteria->condition=$condicion;
		if(is_array($params)){
			$criteria->params=$params;
		}
		$criteria->order=$order;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$pagSize,
			),
		));
	}
}
