<?php

namespace MQM\ShoppingCartBundle\Model;

use MQM\ShoppingCartBundle\Model\ShoppingCartInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartItemInterface;

interface ShoppingCartFactoryInterface {
    
    /**
     * @return ShoppingCartInterface
     */
    public function createCart();
    
    /**
     * @return ShoppingCartItemInterface
     */
    public function createCartItem();
    
    /**
     * @return string 
     */
    public function getCartClass();
    
    /**
     * @return string 
     */
    public function getCartItemClass();
}

?>
