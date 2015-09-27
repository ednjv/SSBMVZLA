<?php

/**
 * This is the model class for table "jugador_posicion_torneo".
 *
 * The followings are the available columns in table 'jugador_posicion_torneo':
 * @property integer $id
 * @property integer $id_jugador
 * @property integer $id_torneo
 * @property integer $posicion
 *
 * The followings are the available model relations:
 * @property Jugador $idJugador
 * @property Torneo $idTorneo
 */
class JugadorPosicionTorneo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jugador_posicion_torneo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_jugador, id_torneo, posicion', 'required'),
			array('id_jugador, id_torneo, posicion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_jugador, id_torneo, posicion', 'safe', 'on'=>'search'),
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
			'id_jugador' => 'Id Jugador',
			'id_torneo' => 'Id Torneo',
			'posicion' => 'Posicion',
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
		$criteria->compare('id_jugador',$this->id_jugador);
		$criteria->compare('id_torneo',$this->id_torneo);
		$criteria->compare('posicion',$this->posicion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JugadorPosicionTorneo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPosiciones($condicion, $params=array(), $order="", $pagSize=5, $with=array()){
		$criteria=new CDbCriteria;
		$criteria->condition=$condicion;
		if(is_array($params)){
			$criteria->params=$params;
		}
		if(is_array($with)){
			$criteria->with=$with;
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
