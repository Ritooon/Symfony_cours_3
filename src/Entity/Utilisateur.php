<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(fields={"username"}, message="Ce nom d'utilisateur est déjà pris")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=10, minMessage="5 caractères minimum", maxMessage="10 caractères maximum")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8, max=16, minMessage="8 caractères minimum", maxMessage="16 caractères maximum")
     */
    private $password;

    /**
     * @Assert\Length(min=8, max=16, minMessage="8 caractères minimum", maxMessage="16 caractères maximum")
     * @Assert\EqualTo(propertyPath="password", message="Les 2 mots de passe ne correspondent pas")
     */
    private $passwordVerification;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPasswordVerification(): ?string
    {
        return $this->passwordVerification;
    }

    public function setPasswordVerification(string $passwordVerification): self
    {
        $this->passwordVerification = $passwordVerification;

        return $this;
    }

    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        
    }

    public function getRoles()
    {
        return [$this->role];
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        if($role === null) { $role = 'ROLE_USER'; }

        $this->role = $role;

        return $this;
    }
}
