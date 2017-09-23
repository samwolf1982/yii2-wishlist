<?php

namespace kriptograf\wishlist;

use yii\db\Expression;

/**
 * wishlist module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * Дата окончания срока действия токена в базе данных
     * @var string
     */
    public $dbDateExpired = 'CURDATE() + INTERVAL 7 DAY';

    /**
     * Время жизни куки с токеном
     * @var string
     */
    public $cokieDateExpired = 86400 * 365;

    public function init()
    {
        parent::init();

    }
}
