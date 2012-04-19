<?php

namespace MQM\ShoppingCartBundle\Entity;

use MQM\ShoppingCartBundle\Model\ShoppingCartFactoryInterface;

class ShoppingCartFactory implements ShoppingCartFactoryInterface
{
    private $cartClass;
    private $cartItemClass;
    
    public function __construct($cartClass, $cartItemClass)
    {
        $this->cartClass = $cartClass;
        $this->cartItemClass = $cartItemClass;
    }
    
    /**
     * {@inheritDoc} 
     */
    public function createCart()
    {
        return new $this->cartClass();
    }
    
    /**
     * {@inheritDoc} 
     */
    public function createCartItem()
    {
        return new $this->cartItemClass();
    }

    /**
     * {@inheritDoc} 
     */
    public function getCartClass()
    {
        return $this->cartClass;
    }

    /**
     * {@inheritDoc} 
     */
    public function getCartItemClass()
    {
        return $this->cartItemClass;
    }
}