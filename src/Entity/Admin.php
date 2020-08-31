<?php

/**
 * Represents a administrator
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({
     *      "user:read:list",
     *      "user:read",
     *      "user:write",
     *      "buyer:read",
     *      "command:read"
     * })
     *
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->roles = ['ROLE_ADMIN'];
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
}
