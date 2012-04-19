<?php

namespace MQM\ShoppingCartBundle\Entity;

use MQM\ShoppingCartBundle\Model\ShoppingCartManagerInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartFactoryInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartInterface;
use MQM\ProductBundle\Model\ProductInterface;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ShoppingCartManager implements ShoppingCartManagerInterface
{
    private $cartFactory;
    private $entityManager;
    private $cartRepository;
   
    public function __construct(EntityManager $entityManager, ShoppingCartFactoryInterface $cartFactory)
    {
        $this->entityManager = $entityManager;
        $this->cartFactory = $cartFactory;
        $cartClass = $cartFactory->getCartClass();
        $this->cartRepository = $entityManager->getRepository($cartClass);
    }
    
    /**
     * {@inheritDoc}
     */
    public function createCart()
    {
       return $this->getCartFactory()->createCart();
    }
    
    /**
     * {@inheritDoc}
     */
    public function createCartItem()
    {
        return $this->getCartFactory()->createCartItem();
    }
    
    /**
     * {@inheritDoc}
     */
    public function saveCart(ShoppingCartInterface $shoppingCart, $andFlush = true)
    {
        $this->getEntityManager()->persist($shoppingCart);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function deleteCart(ShoppingCartInterface $shoppingCart, $andFlush = true)
    {
        $this->getEntityManager()->remove($shoppingCart);
        if ($andFlush) {
            $this->getEntityManager()->flush();
        }
    }
    
    /**
     * {@inheritDoc} 
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function refreshCart(ShoppingCartInterface $shoppingCart)
    {
        $factory = $this->getCartFactory();
        $class = $factory->getCartClass();
        if (!$shoppingCart instanceof $class) {
            throw new UnsupportedUserException('ShoppingCart is not supported.');
        }
        
        return $this->findCartBy(array('id' => $shoppingCart->getId()));
    }
    
    /**
     * {@inheritDoc}
     */
    public function findCartBy(array $criteria)
    {
        return $this->getCartRepository()->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findCarts()
    {
        return $this->getCartRepository()->findAll();
    }
    
    /**
     * {@inheritDoc}
     */
    public function removeAllItemsFromCart(ShoppingCartInterface $shoppingCart)
    {
        if($shoppingCart == null){
            return null;
        }
        $items = $shoppingCart->getItems();
        
        //clear the items in database
        foreach ($items as $item) {
            $this->getEntityManager()->remove($item);
        }
        
        //clear the items in the array itself
        $items->clear();
    }
    
    /**
     * {@inheritDoc}
     */
    public function removeItemFromCart(ShoppingCartInterface $shoppingCart, $itemId)
    {
        if($shoppingCart == null){
            return null;
        }
        $items = $shoppingCart->getItems();
        
        //clear the items in database
        foreach ($items as $item) {
            if($item->getId() == $itemId){
                $this->getEntityManager()->remove($item);
                $items->removeElement($item);
                return true;
            }
            
        }
        return false;
    }
    
    /**
     * {@inheritDoc}
     */
    public function removeItemsWithoutProductsFromCart(ShoppingCartInterface $shoppingCart)
    {
        $items = $shoppingCart->getItems();
        
        if($items == null){
            return $shoppingCart;
        }
        
        foreach ($items as $item) {
            if($item->getQuantity() < 1){
                $this->getEntityManager()->remove($item);
                
                $items->removeElement($item);
            }
        }
        return $shoppingCart;
    }
    
    /**
     * {@inheritDoc}
     */
    public function addProductToCart(ShoppingCartInterface $shoppingCart, ProductInterface $product)
    {
        if ($shoppingCart == null || $product == null) {
            return null;
        }
        $foundItem = null;
        $items = $shoppingCart->getItems();
        foreach ($items as $item) {
            $itemProduct = $item->getProduct();

            if ($itemProduct->getId() == $product->getId()) {
               $foundItem = $item;
               break;
            }
        }
        
        if($foundItem == null){
            $foundItem = $this->createCartItem();
            $foundItem->setProduct($product);
            $shoppingCart->addItem($foundItem);
        }
        
        $foundItem->setQuantity($foundItem->getQuantity() + 1);
        return $shoppingCart;
    }
    
    /**
     *
     * @return ShoppingCartFactoryInterface
     */
    protected function getCartFactory() {
        return $this->cartFactory;
    }    
    
    /**
     *
     * @return EntityManager
     */
    protected function getEntityManager() {
        return $this->entityManager;
    }
    
    /**
     *
     * @return EntityRepository
     */
    protected function getCartRepository() {
        return $this->cartRepository;
    }
}