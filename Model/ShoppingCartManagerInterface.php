<?php

namespace MQM\ShoppingCartBundle\Model;

use MQM\ShoppingCartBundle\Model\ShoppingCartInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartItemInterface;
use MQM\ProductBundle\Model\ProductInterface;

interface ShoppingCartManagerInterface
{
    /**
     * @return ShoppingCartInterface
     */
    public function createCart();

    /**
     * @return ShoppingCartItemInterface
     */
    public function createCartItem();
    
    /**
     *
     * @param ShoppingCartInterface $shoppingCart
     * @param boolean $andFlush 
     */
    public function saveCart(ShoppingCartInterface $shoppingCart, $andFlush = true);
    
    /**
     *
     * @param ShoppingCartInterface $shoppingCart
     * @param boolean $andFlush 
     */
    public function deleteCart(ShoppingCartInterface $shoppingCart, $andFlush = true);
    
    /**
     * @return ShoppingCartManagerInterface
     */
    public function flush();
    
    /**
     *
     * @param ShoppingCartInterface $shoppingCart
     * @return ShoppingCartInterface 
     */
    public function refreshCart(ShoppingCartInterface $shoppingCart);
    
    /**
     * @param array $criteria
     * @return ShoppingCartInterface 
     */
    public function findCartBy(array $criteria);
    
    /**
     * @return array 
     */
    public function findCarts();
    
    /**
     * @return boolean 
     */
    public function isEmpty(ShoppingCartInterface $shoppingCart);
    
    /**
     * Clear the items in the Shopping Cart
     * Important note: it's needed to perform an em->persist() / em->flush() to make this changes permanent
     *
     * @param ShoppingCartInterface $shoppingCart
     */
    public function removeAllItemsFromCart(ShoppingCartInterface $shoppingCart);
    
    /**
     * Remove an items by its id in the Shopping Cart
     * Important note: it's needed to perform an em->persist() / em->flush() to make this changes permanent
     *
     * @param ShoppingCartInterface
     * @param string $itemId
     */
    public function removeItemFromCart(ShoppingCartInterface $shoppingCart, $itemId);
    
    /**
     * Check the quantity of the items and delete every item with quantity = 0
     * @param ShoppingCartInterface $shoppingCart 
     */
    public function removeItemsWithoutProductsFromCart(ShoppingCartInterface $shoppingCart);
    
    /**
     * Add a Product to the ShoppingCart
     * Important note: it's needed to perform an em->persist() / em->flush() to make this changes permanent
     * 
     * @param ShoppingCartInterface $shoppingCart
     * @param Product $product
     * @return ShoppingCartInterface 
     */
    public function addProductToCart(ShoppingCartInterface $shoppingCart, ProductInterface $product);
}