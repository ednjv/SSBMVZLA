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
			array('id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo, ronda', 'required'),
			array('id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo', 'numerical', 'integerOnly'=>true),
			array('ronda', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_jugador_1, id_jugador_2, id_jugador_ganador, id_torneo, ronda, jugador1Aux, jugador2Aux, jugadorGanadorAux, torneoAux', 'safe', 'on'=>'search'),
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
}
