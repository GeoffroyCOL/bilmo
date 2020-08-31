<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhoneRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;

/**
 * @ORM\Entity(repositoryClass=PhoneRepository::class)
 *
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_USER')",
 *          "security_message"="Vous devez être connecté(e) pour accéde à cette zone",
 *          "pagination_items_per_page"=10
 *      },
 *
 *      denormalizationContext={"groups"={"phone:write"}},
 *
 *      collectionOperations={
 *          "POST"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas les droits pour ajouter un nouveau téléphone !"
 *          },
 *          "GET"={
 *              "normalization_context"={"groups"={"phone:read:list"}}
 *          }
 *      },
 *
 *      itemOperations={
 *          "PUT"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas les droits pour modifier un téléphone !"
 *          },
 *          "DELETE"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas les droits pour supprimer un téléphone !"
 *          },
 *          "GET"={
 *              "normalization_context"={"groups"={"phone:read"}}
 *          }
 *      }
 * )
 *
 * @ApiFilter(SearchFilter::class, properties={"name": "partial"}),
 * @ApiFilter(NumericFilter::class, properties={"price", "number", "numberSold"})
 * @ApiFilter(BooleanFilter::class, properties={"active"})
 */
class Phone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({
     *      "command:read",
     *      "phone:read:list",
     *      "command_list:read"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *      "phone:write",
     *      "command:read",
     *      "phone:read:list",
     *      "phone:read",
     *      "command_list:read"
     * })
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     *
     * @Groups({
     *      "phone:write",
     *      "command:read",
     *      "phone:read:list",
     *      "phone:read",
     *      "command_list:read"
     * })
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *      "phone:write",
     *      "phone:read:list",
     *      "phone:read"
     * })
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({
     *      "phone:write",
     *      "phone:read:list",
     *      "phone:read"
     * })
     */
    private $content;

    /**
     * Number of phones offered for sale
     *
     * @ORM\Column(type="integer")
     *
     * @Groups({
     *      "phone:write",
     *      "admin:read:phone"
     * })
     */
    private $number;

    /**
     * Number of phones sold
     *
     * @ORM\Column(type="integer")
     *
     * @Groups({
     *      "admin:read:phone"
     * })
     */
    private $numberSold;

    /**
     * If the phone goes on sale
     *
     * @ORM\Column(type="boolean")
     *
     * @Groups({
     *      "admin:read:phone",
     *      "phone:read"
     * })
     */
    private $active;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->numberSold = 0;
        $this->active = true;
    }
    
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
