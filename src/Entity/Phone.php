<?php

namespace App\Entity;

use App\Repository\PhoneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhoneRepository::class)
 */
class Phone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * Number of phones offered for sale
     * 
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * Number of phones sold
     * 
     * @ORM\Column(type="integer")
     */
    private $numberSold;

    /**
     * If the phone goes on sale
     * 
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    
    /**
     * getId
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * getName
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * setName
     *
     * @param  string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * getPrice
     *
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }
    
    /**
     * setPrice
     *
     * @param  float $price
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
    
    /**
     * getImage
     *
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    /**
     * setImage
     *
     * @param  string $image
     * @return self
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    
    /**
     * getContent
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    
    /**
     * setContent
     *
     * @param  string $content
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
    
    /**
     * getNumber
     *
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }
    
    /**
     * setNumber
     *
     * @param  int $number
     * @return self
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }
    
    /**
     * getNumberSold
     *
     * @return int|null
     */
    public function getNumberSold(): ?int
    {
        return $this->numberSold;
    }
    
    /**
     * setNumberSold
     *
     * @param  int $numberSold
     * @return self
     */
    public function setNumberSold(int $numberSold): self
    {
        $this->numberSold = $numberSold;

        return $this;
    }
    
    /**
     * getActive
     *
     * @return bool|null
     */
    public function getActive(): ?bool
    {
        return $this->active;
    }
    
    /**
     * setActive
     *
     * @param  bool $active
     * @return self
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
    
    /**
     * getCreatedAt
     *
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    /**
     * setCreatedAt
     *
     * @param  DateTimeInterface $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
