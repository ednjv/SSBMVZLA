<?php

/**
 * This is the model class for table "torneo".
 *
 * The followings are the available columns in table 'torneo':
 * @property integer $id
 * @property string $nombre
 * @property integer $id_estado
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Estado $idEstado
 */
class Torneo extends CActiveRecord
{
	public $estadoAux;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'torneo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, id_estado, fecha', 'required'),
			array('id_estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, id_estado, fecha, estadoAux', 'safe', 'on'=>'search'),
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
			'jugadorPosicionTorneos' => array(self::HAS_MANY, 'JugadorPosicionTorneo', 'id_torneo'),
			'pvpSets' => array(self::HAS_MANY, 'PvpSet', 'id_torneo'),
			'idEstado' => array(self::BELONGS_TO, 'Estado', 'id_estado'),
			'torneoImagens' => array(self::HAS_MANY, 'TorneoImagen', 'id_torneo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Name',
			'id_estado' => 'Id Estado',
			'fecha' => 'Date',
			'estadoAux' => 'Location',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('id_estado',$this->id_estado);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('idEstado.nombre',$this->estadoAux,true);
		$criteria->with=array('idEstado');

		$sort=new CSort;
		$sort->defaultOrder="fecha desc";
		$sort->attributes=array(
			'estadoAux'=>array(
				'asc'=>'idEstado.nombre',
				'desc'=>'idEstado.nombre desc'
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
	 * @return Torneo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function selectTorneos(){
		$model=Torneo::model()->findAll(array('select'=>'nombre, id','order'=>'nombre'));
		$lista=CHtml::listdata($model,'id','nombre');
		return $lista;
	}

	protected function beforeSave(){
		$this->fecha=strftime("%Y-%m-%d",strtotime(str_replace("/", "-", $this->fecha)));
		return parent::beforeSave();
	}
}
