<?php 

	class GA2FA{
		
		private $user, $system;
		
		function __construct($user=null, $system=null){
			$this->user=$user;
			$this->system=$system;
			
			if (!$this->user->data->get("tfa_token")){
				$this->user->data->tfa_token=\Word::random(32);
				$this->user->edit("data");
			}
			
			$this->engine=new PHPGangsta_GoogleAuthenticator();
			// $this->secret=md5($system->token);

			
			$this->secret=Base32\Base32::encode(md5($this->user->token.$this->user->data->get("tfa_token").$this->system->token));
			// $this->secret="base".md5($system->token);
			// $this->secret=\Word::random(32);
			$this->username=$this->user->username."@".$this->system->path.".".DOMAIN."";
		}
		
		
		public function enabled(){
			return $this->user->data->getInt("tfa_status");
		}
		
		public function getQR(){
			return $this->engine->getQRCodeGoogleUrl($this->username, $this->secret);
		}
		
		
		
		/**
		 * @desc Get the current generated code
		 * @return string
		 */
		public function getCode(){
			return $this->engine->getCode($this->secret);
		}
		
		
		/**
		 * @desc Safely verify a code submitted from client
		 * @param String $code
		 * @return boolean
		 */
		public function verify($code){
			if (!$this->engine->verifyCode($this->secret, $code)){
				return false;
			}
			
			return true;
		}
		
		
		/**
		 * @desc Validate a login information of a particular email. With safely find the user and try to compare the 2fa submitted from client (code_2fa)
		 * @param String $email
		 */
		final public static function validateLogin($email){
			$user=\User::withEmail($email);
			if (!$user || $user->deactivated()){
				return true;
			}
			
			$status=$user->data->getInt("tfa_status");
			if (!$status){
				return true;
			}
			
			$system=new \sys\System($user->system_id);
			
			if (!$system || !$system->good()){
				return false;
			}
			
			$code=HTML::inputInline("code_2fa");
			
			$sa=new static($user, $system);
			if (!$sa->verify($code)){
				return false;
			}
			
			return true;
		}
		
		
	}


?>