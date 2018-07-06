<?php
namespace kriptograf\wishlist;

use Yii;
use yii\base\Component;
use yii\helpers\Html;

class Wishlist extends Component
{
    /**
     * Список сущностей сохраненных в избранном
     * @return [type] [description]
     */
    public function getUserWishList($type_wish=0)
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
         //   $list[$key]['model'] = $this->findModel($uwl->model, $uwl->item_id);
            $list[$key]['model'] = $this->findModelByType($uwl->model, $uwl->item_id, $type_wish);
        }

        return $list;
    }

    /**
     * [findModel description]
     * @param $model
     * @param $id
     * @param $type_wish
     * @return mixed [type]        [description]
     */
    private function findModel($model, $id)
    {
        $model = '\\'.$model;
        $model = new $model();
        return $model::findOne($id);
    }

    /**
     * [findModel description]
     * @param  [type] $model [description]
     * @param  [type] $id    [description]
     * @return [type]        [description]
     */
    private function findModelByType($model, $id,$type_wish=0)
    {
        $model = '\\'.$model;
        $model = new $model();
        return $model::find()->where(['id'=>$id,'type_wish'=>$type_wish])->one();

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
            return Html::tag('i', ($count)?$count:null, ['id'=>'count-wishlist-badge']);
        }
        else
        {
            $count = \kriptograf\wishlist\models\Wishlist::find()->where(['user_id' => \Yii::$app->user->id])->count();
            return Html::tag('i', ($count)?$count:null, ['id'=>'count-wishlist-badge']);
        }
    }
}
