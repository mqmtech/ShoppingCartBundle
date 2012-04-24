<?php

namespace MQM\ShoppingCartBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use MQM\ShoppingCartBundle\Model\ShoppingCartInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartItemInterface;
use \DateTime;
use Symfony\Component\Validator\Constraints as Assert;

use MQM\ProductBundle\Entity\Product; //TODO: Change it to MQM Product or better use a low coupling value like a productId

/**
 * It's just a CONTAINER (with NO logic) to store the shopping cart
 *
 * @author mqmtech
 * 
 * @ORM\Table(name="shop_shopping_cart_item")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ShoppingCartItem implements ShoppingCartItemInterface
{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $modifiedAt
     *
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * Price per unit
     * 
     * @var float $basePrice
     *
     * @ORM\Column(name="basePrice", type="float", nullable=true)
     */
    private $basePrice;
    
    /**
     *
     * @var float $totalBasePrice
     * @ORM\Column(name="totalBasePrice", type="float", nullable=true)
     */
    private $totalBasePrice;

    /**
     * @Assert\NotBlank(message = "Se debe especificar una cantidad")
     * @Assert\Min(limit = "1", message = "La cantidad debe ser como mínimo 1")
     * 
     * @var integer $quantity
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity = 0;
    
    /**
     *
     * @var Product $product 
     * 
     * @ORM\ManyToOne(targetEntity="MQM\ProductBundle\Entity\Product", cascade={"persist"})
     * @ORM\JoinColumn(name="productId", referencedColumnName="id", nullable=true)
     * 
     */
    private $product;
    
    /**
     *
     * @var ShoppingCartInterface $shoppingCart
     * 
     * @ORM\ManyToOne(targetEntity="MQM\ShoppingCartBundle\Entity\ShoppingCart", inversedBy="items", cascade={"persist"})
     * @ORM\JoinColumn(name="shoppingCartId", referencedColumnName="id", nullable=true)
     */
    private $shoppingCart;
    
    function __construct()
    {
        $this->createdAt = new DateTime();
    }
    
    public function getTotalBasePrice()
    {
        return $this->totalBasePrice;
    }

    public function setTotalBasePrice($totalBasePrice)
    {
        $this->totalBasePrice = $totalBasePrice;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    public function getBasePrice()
    {
        return $this->basePrice;
    }

    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }
    
    public function getShoppingCart()
    {
        return $this->shoppingCart;
    }

    public function setShoppingCart($shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }
}


