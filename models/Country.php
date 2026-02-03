<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $cod_country
 * @property string|null $nombre
 * @property bool|null $active
 *
 * @property Usuario[] $usuarios
 */
class Country extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'active'], 'default', 'value' => null],
            [['cod_country'], 'required'],
            [['active'], 'boolean'],
            [['cod_country'], 'string', 'max' => 3],
            [['nombre'], 'string', 'max' => 50],
            [['cod_country'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cod_country' => 'Cod Country',
            'nombre' => 'Nombre',
            'active' => 'Active',
        ];
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::class, ['cod_country' => 'cod_country']);
    }

}
