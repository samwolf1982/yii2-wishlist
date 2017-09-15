<?php

namespace kriptograf\wishlist\models;

use Yii;

/**
 * This is the model class for table "wishlist".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property date $token_expire
 * @property string $model
 * @property integer $item_id
 */
class Wishlist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'model', 'item_id'], 'required'],
            [['user_id', 'item_id'], 'integer'],
            [['model', 'token', 'token_expire'], 'string', 'max' => 255],
            [['token_expire'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'model' => 'Model',
            'item_id' => 'Item ID',
        ];
    }

    public function getItemModel()
    {

        $model = new $this->model;
        return $model::findOne($this->item_id);



    }


}
