<?php

namespace MQM\ShoppingCartBundle\Entity;

use MQM\UserBundle\Entity\User;
use MQM\ShoppingCartBundle\Model\ShoppingCartInterface;
use MQM\ShoppingCartBundle\Model\ShoppingCartItemInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="shop_shopping_cart")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ShoppingCart implements ShoppingCartInterface
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     *
     * @var float $shippingBasePrice
     * 
     * @ORM\Column(name="shippingBasePrice", type="float", nullable=true)
     */
    private $shippingBasePrice;

    /**
     *
     * @var float $totalProductsBasePrice
     * 
     * @ORM\Column(name="totalProductsBasePrice", type="float", nullable=true)
     */
    private $totalProductsBasePrice;
    
    /**
     * Result of ProductsBasePrice + ShippingBasePrice
     * 
     * @var float $totalBasePrice
     * 
     * @ORM\Column(name="totalBasePrice", type="float", nullable=true)
     */
    private $totalBasePrice;
    
    /**
     * Per unitary tax that must be applied to the totalBasePrice
     *
     * @var float $tax
     * 
     * @ORM\Column(name="tax", type="float", nullable=true)
     */
    private $tax;
    
    /**
     * Result of totalBasePrice * tax
     * @var float $taxPrice 
     * 
     * @ORM\Column(name="taxPrice", type="float", nullable=true)
     */
    private $taxPrice;

    /**
     * Result of totalBasePrice + taxPrice
     * 
     * @var float $totalPrice
     * 
     * @ORM\Column(name="totalPrice", type="float", nullable=true)
     */
    private $totalPrice;

    /**
     *
     * @var string $shippingMethod
     * 
     * @ORM\Column(name="shippingMethod", type="string", length=255, nullable=true)
     */
    private $shippingMethod;

    /**
     *
     * @var ArrayCollection $items of shoppingCartItem
     * @Assert\NotBlank(message = "No hay productos en el carrito")
     * @Assert\NotNull(message = "No hay productos en el carrito")
     * 
     * @ORM\OneToMany(targetEntity="MQM\ShoppingCartBundle\Entity\ShoppingCartItem", mappedBy="shoppingCart", cascade={"persist", "remove"})
     * )
     */
    private $items;
    
    /**
     *
     * @var User $user
     * 
     * @ORM\OneToOne(targetEntity="MQM\UserBundle\Entity\User",  mappedBy="shoppingCart", cascade={"persist"})
     */
    private $user;
    
    
    function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->items = new ArrayCollection();
    }
    
    public function getProductsQuantity()
    {
        $items = $this->getItems();
        
        $quantity = 0;
        foreach ($items as $item) {
            $quantity += $item->getQuantity();
        }
        
        return $quantity;
    }
    
    public function getShippingBasePrice()
    {
        return $this->shippingBasePrice;
    }

    public function setShippingBasePrice($shippingBasePrice)
    {
        $this->shippingBasePrice = $shippingBasePrice;
    }

    public function getTotalProductsBasePrice()
    {
        return $this->totalProductsBasePrice;
    }

    public function setTotalProductsBasePrice($totalProductsBasePrice)
    {
        $this->totalProductsBasePrice = $totalProductsBasePrice;
    }

    public function getTotalBasePrice()
    {
        return $this->totalBasePrice;
    }

    public function setTotalBasePrice($totalBasePrice)
    {
        $this->totalBasePrice = $totalBasePrice;
    }

    public function getTax()
    {
        return $this->tax;
    }

    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    public function getTaxPrice()
    {
        return $this->taxPrice;
    }

    public function setTaxPrice($taxPrice)
    {
        $this->taxPrice = $taxPrice;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
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

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function addItem(ShoppingCartItemInterface $item)
    {
        if ($this->getItems() == null) {
            $this->items = array();
        }
        $this->items[] = $item;
        $item->setShoppingCart($this); //Important to keep the right info in the database
    }

    public function removeItem(ShoppingCartItemInterface $item)
    {
        if ($this->getItems() != null) {
            if (isset($this->items[$item])) {
                unset($this->items[$item]);
            }
        }

        return $this;
    }
    
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}


