<?php

namespace PrestaShop\Module\Kb_Config\Entity;

use Doctrine\ORM\Mapping as ORM;
use PrestaShop\Module\Kb_Config\Helpers\TraitContext;

/**
 * @ORM\Table(name="ps_kb_homecategoryproducts")
 * @ORM\Entity()
 */
class CategoryProducts
{
    use TraitContext;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $title;

    /**
     * @ORM\Column(type="simple_array", length=64)
     */
    private $products;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts($products): self
    {
        $this->products = $products;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'products' => $this->getProducts(),
            'link' => $this->getLink(),
        ];
    }
}
