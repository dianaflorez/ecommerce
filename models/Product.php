<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $image
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property bool|null $is_initial_kit
 * @property bool|null $active
 * @property string|null $created_at
 *
 * @property InvoiceItem[] $invoiceItems
 */
class Product extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'description', 'is_initial_kit', 'active'], 'default', 'value' => null],
            [['name', 'price'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['is_initial_kit', 'active'], 'boolean'],
            [['created_at'], 'safe'],
            [['image'], 'string', 'max' => 177],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'is_initial_kit' => 'Is Initial Kit',
            'active' => 'Active',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[InvoiceItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, ['product_id' => 'id']);
    }

}
