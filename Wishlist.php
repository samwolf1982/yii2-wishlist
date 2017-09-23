<?php
namespace kriptograf\wishlist;

use Yii;
use yii\base\Component;
use yii\yii\helpers\Html;

class Wishlist extends Component
{
    /**
     * Список сущностей сохраненных в избранном
     * @return [type] [description]
     */
    public function getUserWishList()
    {
        $list = [];

        /**
         * если пользователь гость, получить токен из куки
         * и получить данные избранного по токену
         * @var [type]
         */
        if(Yii::$app->user->isGuest)
        {
            $uwlToken = Yii::$app->request->cookies->getValue('uwl_token', null);
            $uwls = \kriptograf\wishlist\models\Wishlist::findAll(['token' => $uwlToken]);
        }
        else
        {
            /**
             * Получить данные по идентификатору пользователя
             * @var [type]
             */
            $uwls = \kriptograf\wishlist\models\Wishlist::findAll(['user_id' => \Yii::$app->user->id]);
        }

        foreach ( $uwls as $key => $uwl ) {
            $list[$key]['model_name'] = $uwl->model;
            $list[$key]['model'] = $this->findModel($uwl->model, $uwl->item_id);
        }

        return $list;
    }

    /**
     * [findModel description]
     * @param  [type] $model [description]
     * @param  [type] $id    [description]
     * @return [type]        [description]
     */
    private function findModel($model, $id)
    {
        $model = '\\'.$model;
        $model = new $model();

        return $model::findOne($id);
    }

    /**
     * Получить количество записей в избранном
     * @return [type] Если записей нет вернуть null иначе венуть количестов записей
     */
    public function getUserWishlistAmount()
    {
        if(Yii::$app->user->isGuest)
        {
            $uwlToken = Yii::$app->request->cookies->getValue('uwl_token', null);
            $count = \kriptograf\wishlist\models\Wishlist::find()->where(['token' => $uwlToken])->count();
            return Html::tag('span', ($count)?$count:null, ['id'=>'count-wishlist-badge']);
        }
        else
        {
            $count = \kriptograf\wishlist\models\Wishlist::find()->where(['user_id' => \Yii::$app->user->id])->count();
            return Html::tag('span', ($count)?$count:null, ['id'=>'count-wishlist-badge']);
        }
    }
}
