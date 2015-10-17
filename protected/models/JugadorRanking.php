<?php

/**
 * This is the model class for table "jugador_ranking".
 *
 * The followings are the available columns in table 'jugador_ranking':
 * @property integer $id
 * @property integer $id_jugador
 * @property integer $puntos
 * @property integer $posicion
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Jugador $idJugador
 */
class JugadorRanking extends CActiveRecord
{
	public $nickAux;
	public $cambio;
	public $personajeJugador;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jugador_ranking';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_jugador, puntos', 'required'),
			array('id_jugador, puntos, posicion, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_jugador, puntos, posicion, status, nickAux', 'safe', 'on'=>'search'),
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
			'idJugador' => array(self::BELONGS_TO, 'Jugador', 'id_jugador'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_jugador' => 'Id Jugador',
			'puntos' => 'Puntos',
			'posicion' => 'Posición',
			'status' => 'Status',
			'nickAux' => 'Jugador',
			'cambio' => 'Cambio (Último Torneo)',
			'personajeJugador' => 'Primario',
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

		$criteria->condition='status=1';
		$criteria->compare('id',$this->id);
		$criteria->compare('id_jugador',$this->id_jugador);
		$criteria->compare('puntos',$this->puntos);
		$criteria->compare('posicion',$this->posicion);
		$criteria->compare('status',$this->status);
		$criteria->compare('idJugador.nick',$this->nickAux,true);
		$criteria->compare('jugadorPersonajes.id_personaje',$this->personajeJugador);
		$criteria->with=array('idJugador'=>array('with'=>array('jugadorPersonajes')));
		$criteria->group='t.id';
		$criteria->together=true;

		$sort=new CSort;
		$sort->defaultOrder='posicion';
		$sort->attributes=array(
			'*',
			'nickAux'=>array(
				'asc'=>'idJugador.nick',
				'desc'=>'idJugador.nick desc',
			),
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
	 * @return JugadorRanking the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function beforeSave(){
		if($this->isNewRecord){
			$this->updateAll(array('status'=>0),'id_jugador=:id_jugador',array(':id_jugador'=>$this->id_jugador));
		}
		return parent::beforeSave();
	}

	public function calcularPosiciones(){
		$busqAll=JugadorRankTemp::model()->findAll(array(
			'condition'=>'status=1',
			'order'=>'puntos desc',
		));
		$i=1;
		foreach($busqAll as $rankJug){
			$rankJug->isNewRecord=false;
			$rankJug->saveAttributes(array(
				'posicion'=>$i,
			));
			$i++;
		}
	}

	/**
	* Función que retorna el cambio de posición de un jugador con respecto al ranking anterior
	* @param idJugador integer id del jugador a calcular el cambio con respecto al ranking anterior
	* @return 
	*/
	public function getCambio($idjugador){
		$rankUltimo=JugadorRanking::model()->find(array(
			'condition'=>'id_jugador=:idjug AND status=0',
			'params'=>array(':idjug'=>$idjugador),
			'order'=>'fecha desc',
			'limit'=>1,
		));
		if($rankUltimo==null){
			return "...";
		}else{
			$rankActual=JugadorRanking::model()->find(array(
				'condition'=>'id_jugador=:idjug AND status=1',
				'params'=>array(':idjug'=>$idjugador),
			));
			if($rankActual->posicion>$rankUltimo->posicion){
				$diferencia=$rankActual->posicion-$rankUltimo->posicion;
				return "<span style='color:red;'>".$diferencia." ".CHtml::tag('i',array('class'=>'glyphicon glyphicon-chevron-down'))."</span>";
			}else{
				if($rankActual->posicion==$rankUltimo->posicion){
					return "...";
				}else{
					if($rankUltimo->posicion>$rankActual->posicion){
						$diferencia=$rankUltimo->posicion-$rankActual->posicion;
						return "<span style='color:green;'>".$diferencia." ".CHtml::tag('i',array('class'=>'glyphicon glyphicon-chevron-up'))."</span>";
					}
				}
			}
		}
	}
}
