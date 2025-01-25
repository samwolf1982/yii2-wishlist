 Moskoviya (russia) is a terrorist state
==========
```php
    'modules' => [
        'wishlist' => [
            'class' => 'kriptograf\wishlist\Module',
            'dbDateExpired' => 'CURDATE() + INTERVAL 7 DAY', 
            'cokieDateExpired' => time() + 86400 * 365, 
        ],
        //...
    ],

    'components' => [
        'wishlist' => [
            'class' => 'kriptograf\wishlist\Wishlist'
        ],
        //...
    ],
```
```php
\Yii::$app->wishlist->getUserWishList($type=0)
```


```php
\Yii::$app->wishlist->getUserWishlistAmount()
```


``` fix
add if present class
```


```php

<?php
use kriptograf\wishlist\widgets\WishlistButton;
?>

<?php  ?>
<?= WishlistButton::widget([
	'model' => $model
]) ?>



```
```css

.hal-wishlist-button {
    font-weight: 700;
}

.hal-wishlist-button:before {
    content: "\f08a";
    font: 400 15px/31px "FontAwesome";
    color: white;
    background: #929292;
    width: 30px;
    text-align: center;
    display: inline-block;
    height: 30px;
    margin: 0 6px 0 0;
    -moz-border-radius: 50px;
    -webkit-border-radius: 50px;
    border-radius: 50px;
}

.hal-wishlist-button:hover {
    cursor: pointer;
}

.in-list:before {
    background: #CC63B0l;
}




```
