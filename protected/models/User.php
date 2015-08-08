<?php
/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $create_at
 * @property string $lastvisit_at
 * @property integer $superuser
 * @property integer $status
 * @property string $photo
 * @property string $cedula
 */
class User extends CActiveRecord
{
	
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return whether user's password is correct
	 */
	public function ValidatePassword($userPassword) 
	{
		return $this->hashPassword($userPassword)===$this->password; 
	}

	/**
	 * @return user's password encryted
	 */
	public function hashPassword($userPassword) 
	{
		return md5($userPassword); 
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, cedula', 'required'),
			array('email', 'email'),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => "La contraseña debe tener almenos 4 caracteres."),
			array('username, cedula', 'length', 'max'=>20),
			array('username', 'unique', 'message' =>"Este nombre de usuario ya está siendo utilizado."),
			array('email', 'unique', 'message' =>"Esta dirección de correo ya está siendo utilizado."),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => "El nombre de usuario debe tener entre 3 y 20 caracteres."),
			array('create_at', 'default', 'value'=>new CDbExpression('NOW()'), 'on'=>'insert'),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE)),
			array('status', 'numerical', 'integerOnly'=>true),
			array('photo', 'length', 'max'=>100, 'on'=>'insert,update'),
			array('photo', 'file', 'types'=>'jpg,png,jpeg','allowEmpty'=>true, 'on'=>'update', 'maxSize'=>1024*1024*2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, create_at, lastvisit_at, status, photo, cedula', 'safe', 'on'=>'search'),
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
			);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Nombre de usuario',
			'password' => 'Contraseña',
			'email' => 'Email',
			'create_at' => 'Fecha de registro',
			'lastvisit_at' => 'Ultima visita',
			'status' => 'Status',
			'photo' => 'Fotografía',
			'cedula' => 'Cédula',
			'photoAux' => 'Fotografía',
			);
	}

	public function scopes()
	{
		return array(
			'active'=>array(
				'condition'=>'status='.self::STATUS_ACTIVE,
				),
			'notactive'=>array(
				'condition'=>'status='.self::STATUS_NOACTIVE,
				),
			);
	}


	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => 'Inactivo',
				self::STATUS_ACTIVE => 'Activo',
				),
			);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
	
	public function saveUsuario($post)
	{
		if(isset($post))
		{         
			$this->attributes=$post;
			if ($this->password == '') {
				unset ($this->password) ;
			}else{
				$this->password = $this->hashPassword($this->password);
			}
			$uploadFile = CUploadedFile::getInstance($this,'photo');
			if($uploadFile){
				$fileName= uniqid(rand(), true).'.'.$uploadFile->extensionName;
				$this->photo = $fileName;
			}
			
			if($this->save()){
				if($uploadFile){
					$path= "/var/www".Yii::app()->request->baseUrl."/usuarios/";
					if(!is_dir($path)) mkdir($path);
					$path = $path."/".$fileName;
					$uploadFile->saveAs($path);    
				}
				return true;
			} else {
				return false;
			}
		}
	}
	

	public function getDatosFuncionario($cedula){
		$rawData = Yii::app()->dbOracle
		->createCommand('SELECT 
			PERSONA.CEDULA, 
			PERSONA.PRIMER_NOMBRE,
			PERSONA.SEGUNDO_NOMBRE,
			PERSONA.PRIMER_APELLIDO,
			PERSONA.SEGUNDO_APELLIDO,
			T_EMPLEADO.FECHA_INGRESO,
			T_EMPLEADO.CUENTA_CORRIENTE,
			CARGO.NOMBRE AS "CARGO",
			DEPARTAMENTO.NOMBRE AS "DEPARTAMENTO"
			FROM PERSONA 
			JOIN T_EMPLEADO ON T_EMPLEADO.ID_PERSONA = PERSONA.ID_PERSONA 
			JOIN DEPARTAMENTO ON DEPARTAMENTO.CODIGO_DEP = T_EMPLEADO.CODIGO_DEP 
			JOIN CARGO ON CARGO.CODIGO_CARGO = T_EMPLEADO.CODIGO_CARGO 
			WHERE T_EMPLEADO.FECHA_EGRESO IS NULL AND PERSONA.CEDULA='.$cedula)
		->queryAll();
		if($rawData)
			return $rawData;
		
	}

	public function afterFind()
	{
            //reset the password to null because we don't want the hash to be shown.
		if(Yii::app()->controller->action->id == 'update') {
			$this->password = null;
		}

		parent::afterFind();
	}

	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('lastvisit_at',$this->lastvisit_at,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('cedula',$this->cedula,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			));
	}

	public function selectUsers(){
		$model=User::model()->findAll(array('order'=>'username'));
		$lista=CHtml::listdata($model,'id','username');
		return $lista;
	}
}