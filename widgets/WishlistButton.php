<?php
namespace kriptograf\wishlist\widgets;

use yii\helpers\Html;
use kriptograf\wishlist\models\Wishlist;
use yii\helpers\Url;
use yii;

class WishlistButton extends \yii\base\Widget
{
    public $anchorActive = NULL;
    public $anchorUnactive = NULL;
    public $anchorTitleActive = NULL;
    public $anchorTitleUnactive = NULL;
    public $model = NULL;
    public $cssClass = NULL;
    public $cssClassInList = NULL;
    public $htmlTag = 'div';

    public function init()
    {
        parent::init();

        \kriptograf\wishlist\assets\WidgetAsset::register($this->getView());

        if ($this->anchorActive === NULL) {
            $this->anchorActive = 'В избранном';
        }

        if ($this->anchorUnactive === NULL) {
            $this->anchorUnactive = 'В избранное';
        }

        if ($this->anchorTitleActive === NULL) {
            $this->anchorTitleActive = 'В избранном';
        }

        if ($this->anchorTitleUnactive === NULL) {
            $this->anchorTitleUnactive = 'Добавить в избранное';
        }

        $anchor = [
            'active' => $this->anchorActive,
            'unactive' => $this->anchorUnactive,
            'activeTitle' => $this->anchorTitleActive,
            'unactiveTitle' => $this->anchorTitleUnactive
        ];

        if ($this->cssClass === NULL) {
            $this->cssClass = 'hal-wishlist-button';
        }

        if ($this->cssClassInList === NULL) {
            $this->cssClassInList = 'in-list';
        }

        $this->getView()->registerJs("wishlist.anchor = ".json_encode($anchor));

        return true;
    }

    public function run()
    {
        if (!is_object($this->model)) {
            return false;
        }

        $action = 'add';
        $url = '/wishlist/element/add';
        $model = $this->model;
        $text = $this->anchorUnactive;
        $title = $this->anchorTitleUnactive;

        if(Yii::$app->user->isGuest)
        {
            $uwlToken = Yii::$app->request->cookies->getValue('uwl_token', null);
            $elementModel = Wishlist::find()->where([
                'token' => $uwlToken,
                'model' => $model::className(),
                'item_id' => $model->id,
                ])->one();
        }
        else
        {
            $elementModel = Wishlist::find()->where([
                'user_id' => \Yii::$app->user->id,
                'model' => $model::className(),
                'item_id' => $model->id,
                ])->one();
        }



        if ($elementModel) {
            $text = $this->anchorActive;
            $title = $this->anchorTitleActive;
            $this->cssClass .= ' '.$this->cssClassInList;
            $action = 'remove';
            $url = '/wishlist/element/remove';
        }

        return Html::tag($this->htmlTag, $text, [
            'class' => $this->cssClass,
            'data-role' => 'hal_wishlist_button',
            'data-url' => Url::toRoute($url),
            'data-action' => $action,
            'data-in-list-css-class' => $this->cssClassInList,
            'data-item-id' => $model->id,
            'data-model' => $model::className(),
            'title' => $title,
        ]);
    }
}
