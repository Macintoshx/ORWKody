<?php
/**
 * Created by PhpStorm.
 * User: grzes
 * Date: 3/21/2016
 * Time: 10:39 PM
 */

namespace common\components\services;


use app\models\OauthUsers;
use app\models\UserAuthMethod;
use common\components\UserInfo;
use common\models\User;
use Yii;

class UserService
{
	public static function OAuthLogin($email, $name, $oauthid)
	{
		$user = User::find()->where(['email' => $email])->one();
		if(!is_null($user))
		{
			Yii::$app->user->login($user);
		}
		else
		{
			$user = new User();
			$user->email = $email;
			$user->username = $name . "_" . Yii::$app->security->generateRandomString(5);
			$user->setPassword(Yii::$app->security->generateRandomString(20));
			$user->status = 10;
			$user->generateAuthKey();
			if(!$user->save())
			{
				throw new \Exception("Error on creating OAuth user");
			}

			$userMeth = new UserAuthMethod();
			$userMeth->user_id = $user->id;
			$userMeth->auth_method = "facebook";
			if(!$userMeth->save())
			{
				throw new \Exception("Error on saving user auth method");
			}

			$oauthUser = new OauthUsers();
			$oauthUser->oauth_id = $oauthid;
			$oauthUser->oauth_provider = "facebook";
			$oauthUser->oauth_uname = $name;
			$oauthUser->user_email = $email;
			if(!$oauthUser->save())
			{
				throw new \Exception("Error on save OAuth Data");
			}

			Yii::$app->user->login($user);
		}
	}

	public static function getUserData()
	{
		$ret = new UserInfo(Yii::$app->user->getId());
		return $ret;
	}
}