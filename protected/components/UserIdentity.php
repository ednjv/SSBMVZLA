<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

	private $id;
	const ERROR_STATUS_NOACTIVE=3;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users=User::model()->findByAttributes(array('username'=>$this->username));

		if($users===null)

			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$users->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($users->status==0)
			$this->errorCode=self::ERROR_STATUS_NOACTIVE;
		else 
		{
			$this->id=$users->id;
                        $this->setState('__email', $users->email);
                        $this->setState('__photo', $users->photo);
			$this->username=$users->username;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

    /**
    * @return integer the ID of the user record
    */
	public function getId()
	{
		return $this->id;
	}
        
  

}