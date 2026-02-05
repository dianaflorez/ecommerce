<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $name
 * @property string $lastname
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string|null $phone
 * @property string|null $identification
 * @property string $cod_country
 * @property string $usercode
 * @property int|null $parent_id
 * @property string $role
 * @property string $status
 * @property int|null $active
 * @property string|null $active_desc
 * @property string|null $auth_key
 * @property string|null $access_token
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $user_updated
 *
 * @property ApprovalLogs[] $approvalLogs
 * @property ApprovalLogs[] $approvalLogs0
 * @property Country $codCountry
 * @property Orders[] $orders
 * @property Usuario $parent
 * @property Usuario[] $usuarios
 */
class Usuario extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_DISTRIBUTOR = 'distributor';
    const ROLE_CLIENTE = 'cliente';
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ACTIVE = 'active';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'identification', 'parent_id', 'active_desc', 'auth_key', 'access_token', 'user_updated'], 'default', 'value' => null],
            [['role'], 'default', 'value' => 'cliente'],
            [['status'], 'default', 'value' => 'pending'],
            [['active'], 'default', 'value' => 0],
            [['name', 'lastname', 'email', 'username', 'password', 'cod_country', 'usercode'], 'required'],
            [['parent_id', 'active', 'user_updated'], 'default', 'value' => null],
            [['parent_id', 'active', 'user_updated'], 'integer'],
            [['role', 'status', 'active_desc'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'lastname'], 'string', 'max' => 100],
            [['email', 'username'], 'string', 'max' => 150],
            [['password'], 'string', 'max' => 255],
            [['phone', 'identification'], 'string', 'max' => 50],
            [['cod_country'], 'string', 'max' => 3],
            [['usercode'], 'string', 'max' => 20],
            [['auth_key', 'access_token'], 'string', 'max' => 40],
            ['role', 'in', 'range' => array_keys(self::optsRole())],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['usercode'], 'unique'],
            [['email'], 'unique'],
            [['identification'], 'unique'],
            [['username'], 'unique'],
            [['cod_country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['cod_country' => 'cod_country']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'phone' => 'Phone',
            'identification' => 'Identification',
            'cod_country' => 'Cod Country',
            'usercode' => 'Usercode',
            'parent_id' => 'Parent ID',
            'role' => 'Role',
            'status' => 'Status',
            'active' => 'Active',
            'active_desc' => 'Active Desc',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_updated' => 'User Updated',
        ];
    }

    /**
     * Gets query for [[ApprovalLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApprovalLogs()
    {
        return $this->hasMany(ApprovalLogs::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ApprovalLogs0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApprovalLogs0()
    {
        return $this->hasMany(ApprovalLogs::class, ['admin_id' => 'id']);
    }

    /**
     * Gets query for [[CodCountry]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCodCountry()
    {
        return $this->hasOne(Country::class, ['cod_country' => 'cod_country']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Usuario::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::class, ['parent_id' => 'id']);
    }


    /**
     * column role ENUM value labels
     * @return string[]
     */
    public static function optsRole()
    {
        return [
            self::ROLE_ADMIN => 'admin',
            self::ROLE_DISTRIBUTOR => 'distributor',
            self::ROLE_CLIENTE => 'cliente',
        ];
    }

    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_PENDING => 'pending',
            self::STATUS_APPROVED => 'approved',
            self::STATUS_REJECTED => 'rejected',
            self::STATUS_ACTIVE => 'active',
        ];
    }

    /**
     * @return string
     */
    public function displayRole()
    {
        return self::optsRole()[$this->role];
    }

    /**
     * @return bool
     */
    public function isRoleAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function setRoleToAdmin()
    {
        $this->role = self::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public function isRoleDistributor()
    {
        return $this->role === self::ROLE_DISTRIBUTOR;
    }

    public function setRoleToDistributor()
    {
        $this->role = self::ROLE_DISTRIBUTOR;
    }

    /**
     * @return bool
     */
    public function isRoleCliente()
    {
        return $this->role === self::ROLE_CLIENTE;
    }

    public function setRoleToCliente()
    {
        $this->role = self::ROLE_CLIENTE;
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function setStatusToPending()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isStatusApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function setStatusToApproved()
    {
        $this->status = self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isStatusRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function setStatusToRejected()
    {
        $this->status = self::STATUS_REJECTED;
    }

    /**
     * @return bool
     */
    public function isStatusActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function setStatusToActive()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    // DF
    public function getFullname()
    {
        return "$this->name $this->lastname";
    }
    public function getUpdatedBy()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'user_updated']);
    }
    public static function rolesList()
    {
        return [
            'cliente' => 'Cliente',
            'distributor' => 'Distribuidor',
            'admin' => 'Administrador',
            //'superadmin' => 'Super Administrador',
        ];
    }

    public static function statusList()
    {
        return [
            'pending' => 'Pendiente', 
            'approved' => 'Aprobado', 
            'rejected' => 'Rechazado', 
            'active' => 'Activo',
        ];
    }

}
