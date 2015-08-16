<?php

/**
 * This is the model class for table "jugador_rank_temp".
 *
 * The followings are the available columns in table 'jugador_rank_temp':
 * @property integer $id
 * @property integer $id_jugador
 * @property integer $puntos
 * @property integer $posicion
 * @property integer $status
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Jugador $idJugador
 */
class JugadorRankTemp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jugador_rank_temp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_jugador, puntos, posicion, status, fecha', 'required'),
			array('id_jugador, puntos, posicion, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_jugador, puntos, posicion, status, fecha', 'safe', 'on'=>'search'),
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
			'posicion' => 'Posicion',
			'status' => 'Status',
			'fecha' => 'Fecha',
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
		$criteria->compare('puntos',$this->puntos);
		$criteria->compare('posicion',$this->posicion);
		$criteria->compare('status',$this->status);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JugadorRankTemp the static model class
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
}
