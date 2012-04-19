<?php

namespace MQM\ShoppingCartBundle\Test\ShoppingCart;

use MQM\ShoppingCartBundle\ShoppingCart\ShoppingCartInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartManagerInterface;
use Symfony\Bundle\FrameworkBundle\Tests\Functional\AppKernel;

class ShoppingCartManagerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{   
    protected $_container;
    private $shoppingCartManager;

    public function __construct()
    {
        parent::__construct();
        
        $client = static::createClient();
        $container = $client->getContainer();
        $this->_container = $container;  
    }
    
    protected function setUp()
    {
        $this->shoppingCartManager = $this->get('mqm_cart.cart_manager');
    }

    protected function tearDown()
    {
        $this->resetShoppingCarts();
    }

    protected function get($service)
    {
        return $this->_container->get($service);
    }
    
    public function testGetAssertManager()
    {
        $this->assertNotNull($this->shoppingCartManager);
    }
    
    private function resetShoppingCarts()
    {
        $categories = $this->shoppingCartManager->findCarts();
        foreach ($categories as $shoppingCart) {
            $this->shoppingCartManager->deleteCart($shoppingCart, false);
        }
        $this->shoppingCartManager->flush();
    }
}
