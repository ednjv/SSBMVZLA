<?php

class UserUpdatePassword extends CFormModel {
        public $oldPassword;
        public $password;
        public $verifyPassword;
       
	public function rules() {
		return  array(
			array('oldPassword, password, verifyPassword', 'required'),
			array('oldPassword, password, verifyPassword', 'length', 'max'=>128, 'min' => 4,'message' => "Contraseña incorrecta (mínimo 4 caracteres)."),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => "La contraseña no coincide."),
			array('oldPassword', 'verifyOldPassword'),
		);
	}
        
  	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'oldPassword'=>'Contraseña Actual',
			'password'=>"Nueva Contraseña",
			'verifyPassword'=>"Corfimarcion  de Contraseña",
		);
	}   
        
        /**
         * Update Password
         */
        public function UpdatePassword($post, $id){
            if($id==Yii::app()->user->id){
              $modelUser=User::model()->findByPk($id);
              if(isset($post)) {
                 $this->attributes=$post;
                 $passwordMd5 = $modelUser->hashPassword($this->password);
                      if($this->validate()){
                        if ($modelUser->updateByPk($id, array('password'=>$passwordMd5))){
                            return true;
                        } else {
                            return false;
                        }                                
                      }  
              }     
            }
        }
        
	/**
	 * Verify Old Password
	 */
	 public function verifyOldPassword($attribute, $params)
	 {
		 if (User::model()->findByPk(Yii::app()->user->id)->password != User::model()->hashPassword($this->$attribute))
			 $this->addError($attribute, "Contraseña actual incorrecta.");
	 }
}

?>
