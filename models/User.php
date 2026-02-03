<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $auth_key;
    public $access_token;

    public $name;
    public $lastname;
    public $email;
   
    public $phone;
    public $identification;

    public $cod_country;

    public $usercode;
    public $parent_id;

    public $role;
    public $status;

    public $active;
    public $active_desc;

    public $created_at;
    public $updated_at;
    public $user_updated;

    public static function isSuperAdmin($id)
    {
       if (Usuario::findOne(['id' => $id, 'active' => '1', 'role' => 'superadmin'])){
        return true;
       } else {
  
        return false;
       }
    }

    public static function isAdmin($id)
    {
       if (Usuario::findOne(['id' => $id, 'active' => '1', 'role' => 'admin'])){
        return true;
       } else {
  
        return false;
       }
    }
  
    public static function isDistribuidor($id)
    {
       if (Usuario::findOne(['id' => $id, 'active' => '1', 'role' => 'distribuidor'])){
        return true;
       } else {
  
        return false;
       }
    }
  
    /**
     * {@inheritdoc}
     */
    // public static function findIdentity($id)
    // {
    //     return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    // }
    public static function findIdentity($id)
    {
        $user = Usuario::find()
              ->where("active=:active", [":active" => 1])
              ->andWhere("id=:id", ["id" => $id])
              ->one();

        return isset($user) ? new static($user) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    // public static function findByUsername($username)
    // {
    //     foreach (self::$users as $user) {
    //         if (strcasecmp($user['username'], $username) === 0) {
    //             return new static($user);
    //         }
    //     }

    //     return null;
    // }
    public static function findByUsername($username)
    {
        $users = Usuario::find()
            ->where("active=:active", ["active" => 1])
            ->andWhere("username=:username", [":username" => $username])
            ->all();
    
        foreach ($users as $user) {
            if (strcasecmp($user->username, $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {

        /* Valida el password */
        if (crypt($password, $this->password) == $this->password)
        {
            return $password === $password;
        }
    }
}
