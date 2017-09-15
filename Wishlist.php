<?php
namespace kriptograf\wishlist;

use yii\base\Component;

class Wishlist extends Component
{
    public function getUserWishList()
    {
        $list = [];

        foreach ( \kriptograf\wishlist\models\Wishlist::findAll(['user_id' => \Yii::$app->user->id]) as $uwl ) {
            $list[] = $this->findModel($uwl->model, $uwl->item_id);
        }

        return $list;
    }

    private function findModel($model, $id)
    {
        $model = '\\'.$model;
        $model = new $model();

        return $model::findOne($id);
    }

    public function getUserWishlistAmount()
    {
        return \kriptograf\wishlist\models\Wishlist::find()->where(['user_id' => \Yii::$app->user->id])->count();
    }
}
