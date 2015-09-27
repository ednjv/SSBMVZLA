<?php

/**
 * This is the model class for table "jugador".
 *
 * The followings are the available columns in table 'jugador':
 * @property integer $id
 * @property string $primer_nombre
 * @property string $primer_apellido
 * @property string $nick
 * @property integer $id_estado
 *
 * The followings are the available model relations:
 * @property Estado $idEstado
 * @property JugadorPersonaje[] $jugadorPersonajes
 * @property PvpSet[] $pvpSets
 * @property PvpSet[] $pvpSets1
 * @property PvpSet[] $pvpSets2
 */
class Jugador extends CActiveRecord
{
	public $estadoAux;
	public $paisAux;
	public $personajePrimario;
	public $winrateAux;
	public $recordAux;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jugador';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('primer_nombre, nick, id_estado', 'required'),
			array('id_estado', 'numerical', 'integerOnly'=>true),
			array('primer_nombre, primer_apellido', 'length', 'max'=>50),
			array('nick', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, primer_nombre, primer_apellido, nick, id_estado, estadoAux, paisAux, personajePrimario', 'safe', 'on'=>'search'),
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
			'idEstado' => array(self::BELONGS_TO, 'Estado', 'id_estado'),
			'jugadorPersonajes' => array(self::HAS_MANY, 'JugadorPersonaje', 'id_jugador'),
			'pvpSets' => array(self::HAS_MANY, 'PvpSet', 'id_jugador_1'),
			'pvpSets1' => array(self::HAS_MANY, 'PvpSet', 'id_jugador_2'),
			'pvpSets2' => array(self::HAS_MANY, 'PvpSet', 'id_jugador_ganador'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'primer_nombre' => 'Nombre',
			'primer_apellido' => 'Apellido',
			'nick' => 'Nick',
			'id_estado' => 'Id Estado',
			'estadoAux' => 'Estado',
			'paisAux' => 'País',
			'personajePrimario' => 'Personaje Primario',
			'winrateAux' => '% de Victorias',
			'recordAux' => 'Récord',
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
		$criteria->select=array(
			'*',
			'(
				select count(*) as wins
				from jugador jug1
				join pvp_set p1 on jug1.id=p1.id_jugador_ganador
				where t.id = p1.id_jugador_ganador
			) as wins',
			'(
				select count(*) as loses1
				from jugador jug2
				join pvp_set p2 on jug2.id=p2.id_jugador_1
				where t.id = p2.id_jugador_1 AND t.id != p2.id_jugador_ganador
			) as loses1',
			'(
				select count(*) as loses2
				from jugador jug3
				join pvp_set p3 on jug3.id=p3.id_jugador_2
				where t.id = p3.id_jugador_2 AND t.id != p3.id_jugador_ganador
			) as loses2',
		);
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.primer_nombre',$this->primer_nombre,true);
		$criteria->compare('t.primer_apellido',$this->primer_apellido,true);
		$criteria->compare('t.nick',$this->nick,true);
		$criteria->compare('t.id_estado',$this->id_estado);
		$criteria->compare('idEstado.nombre',$this->estadoAux,true);
		$criteria->compare('idPais.nombre',$this->paisAux,true);
		$criteria->compare('idPersonaje.id',$this->personajePrimario);
		$criteria->addSearchCondition('primario',1,"=","AND");
		$criteria->group='t.id';
		$criteria->with=array(
			'idEstado'=>array(
				'with'=>array(
					'idPais'
				)
			),
			'jugadorPersonajes'=>array(
				'with'=>array(
					'idPersonaje'
				)
			),
		);
		$criteria->together=true;

		$sort=new CSort;
		$sort->defaultOrder='t.nick';
		$sort->attributes=array(
			'estadoAux'=>array(
				'asc'=>'idEstado.nombre',
				'desc'=>'idEstado.nombre desc'
			),
			'paisAux'=>array(
				'asc'=>'idPais.nombre',
				'desc'=>'idPais.nombre desc'
			),
			'recordAux'=>array(
				'asc'=>'wins',
				'desc'=>'wins desc'
			),
			'winrateAux'=>array(
				'asc'=>'wins/(wins+loses1+loses2)',
				'desc'=>'wins/(wins+loses1+loses2) desc'
			),
			'*'
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
	 * @return Jugador the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function selectJugadores(){
		$model=Jugador::model()->findAll(array(
			'with'=>array('idEstado'=>array('with'=>array('idPais'))),
			'select'=>array('CONCAT(primer_nombre," ",primer_apellido," (",nick,", ", idEstado.nombre, ", ", idPais.nombre,")") as primer_nombre','id'),
			'order'=>'primer_nombre',
		));
		$lista=CHtml::listdata($model,'id','primer_nombre');
		return $lista;
	}

	public function getRecord($idJugador){
		$wins=PvpSet::model()->count(array(
			'condition'=>'(id_jugador_1=:idJugador OR id_jugador_2=:idJugador) AND id_jugador_ganador=:idJugador',
			'params'=>array(':idJugador'=>$idJugador),
		));
		$loses=PvpSet::model()->count(array(
			'condition'=>'(id_jugador_1=:idJugador OR id_jugador_2=:idJugador) AND id_jugador_ganador!=:idJugador',
			'params'=>array(':idJugador'=>$idJugador),
		));
		return $wins." W - ".$loses. " L";
	}

	public function getPersonajes($idJugador,$primary=false){
		$personajes=JugadorPersonaje::model()->findAll(array(
			'condition'=>'id_jugador=:idJugador',
			'params'=>array(':idJugador'=>$idJugador),
			'order'=>'primario desc',
		));
		$imagenes="";
		$countP=count($personajes);
		if($countP>0){
			foreach ($personajes as $personaje){
				$imagenes=CHtml::image(Yii::app()->BaseUrl."/images/".$personaje->idPersonaje->imagen)." ".$imagenes;
				if($primary==true){
					return $imagenes;
				}
			}
		}
		return $imagenes;
	}

	public function getRecordVs($idJugadorActual,$idJugadorComparar){
		$wins=PvpSet::model()->count(array(
			'condition'=>'(id_jugador_1=:idJugadorActual OR id_jugador_2=:idJugadorActual) AND (id_jugador_1=:idJugadorComparar OR id_jugador_2=:idJugadorComparar) AND id_jugador_ganador=:idJugadorActual',
			'params'=>array(':idJugadorActual'=>$idJugadorActual,':idJugadorComparar'=>$idJugadorComparar),
		));
		$loses=PvpSet::model()->count(array(
			'condition'=>'(id_jugador_1=:idJugadorActual OR id_jugador_2=:idJugadorActual) AND (id_jugador_1=:idJugadorComparar OR id_jugador_2=:idJugadorComparar) AND id_jugador_ganador!=:idJugadorActual',
			'params'=>array(':idJugadorActual'=>$idJugadorActual,':idJugadorComparar'=>$idJugadorComparar),
		));
		return $wins." W - ".$loses. " L";
	}

	public function getWinRate(){
		$wins=PvpSet::model()->count(array(
			'condition'=>'(id_jugador_1=:idJugador OR id_jugador_2=:idJugador) AND id_jugador_ganador=:idJugador',
			'params'=>array(':idJugador'=>$this->id),
		));
		$loses=PvpSet::model()->count(array(
			'condition'=>'(id_jugador_1=:idJugador OR id_jugador_2=:idJugador) AND id_jugador_ganador!=:idJugador',
			'params'=>array(':idJugador'=>$this->id),
		));
		$WinRate=0;
		$total=$wins+$loses;
		if($total>0){
			$WinRate=$wins*100/$total;
		}
		return number_format($WinRate,1);
	}
}
