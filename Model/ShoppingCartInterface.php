<?php

namespace MQM\ShoppingCartBundle\Model;

use MQM\ShoppingCartBundle\Model\ShoppingCartItemInterface;

interface ShoppingCartInterface {
    
    public function getProductsQuantity();
    
    public function getShippingBasePrice();

    public function setShippingBasePrice($shippingBasePrice);

    public function getTotalProductsBasePrice();

    public function setTotalProductsBasePrice($totalProductsBasePrice);

    public function getTotalBasePrice();

    public function setTotalBasePrice($totalBasePrice);

    public function getTax();

    public function setTax($tax);

    public function getTaxPrice();

    public function setTaxPrice($taxPrice);

    public function getTotalPrice();

    public function setTotalPrice($totalPrice);

    public function getShippingMethod();

    public function setShippingMethod($shippingMethod);

    public function getId();
    
    public function setId($id);

    public function getName();

    public function setName($name);

    public function getDescription();

    public function setDescription($description);

    public function getCreatedAt();

    public function setCreatedAt($createdAt);

    public function getModifiedAt();

    public function setModifiedAt($modifiedAt);

    public function getItems();

    public function setItems($items);
    
    public function addItem(ShoppingCartItemInterface $item);
    
    public function getUser();

    public function setUser($user);
}


