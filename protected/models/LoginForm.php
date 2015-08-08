<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username', 'required', 'message'=>'Por favor ingrese su nombre de ususario.'),
                        array('password', 'required', 'message'=>'Por favor ingrese su contraseña.'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Recordarme la proxima vez',
			'username'=>'Nombre de usuario',
			'password'=>'Contraseña',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				switch ($this->_identity->errorCode) 
				{
					default:
						$this->addError("password", "Nombre de usuario o Contraseña incorrecta. ");
						break;				
					case UserIdentity::ERROR_STATUS_NOACTIVE:
						$this->addError("password","Cuenta inactiva. ");
						break;					

				}
				
		}
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
                
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=0; 
            Yii::app()->user->login($this->_identity,$duration);
                                
			return true;
		}
		else
			return false;
	}




}
