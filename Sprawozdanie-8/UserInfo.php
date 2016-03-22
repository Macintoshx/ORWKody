<?php
/**
 * Created by PhpStorm.
 * User: grzes
 * Date: 3/21/2016
 * Time: 11:25 PM
 */

namespace common\components;


use app\models\OauthUsers;
use app\models\UserAuthMethod;
use common\models\User;

class UserInfo
{
	public $email;
	public $name;
	public function __construct($id)
	{
		$u = User::find()->where(["id" => $id])->one();
		$this->email = $u->email;

		$lmethod = UserAuthMethod::find()->where(['user_id' => $id])->one();
		switch($lmethod->auth_method)
		{
			case "facebook":
				$oauth = OauthUsers::findOne(['user_email' => $u->email]);
				$this->name = $oauth->oauth_uname;
				break;
			case "db":
			default:
				$this->name = $u->username;
				break;
		}
	}
}