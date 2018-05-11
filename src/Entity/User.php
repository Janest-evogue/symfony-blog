<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserInterface et Serializable sont des interfaces que la classe
 * doit implémenter pour être utilisée avec le composant Security
 * de Symfony pour la gestion utilisateur
 * 
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email",
 *     message="Il existe déjà un utilisateur avec cet email")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Assert\Length(max="100",
     * maxMessage="Le nom ne doit pas faire plus de {{ limit }} caractères")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Assert\Length(max="100",
     * maxMessage="Le prénom ne doit pas faire plus de {{ limit }} caractères")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="L'email est obligatoire")
     * @Assert\Email(message="Cet email n'est pas valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $role = 'ROLE_USER';
    
    /**
     * Mot de passe en clair pour interagir avec
     * le formulaire
     * 
     * @var string
     * @Assert\NotBlank(message="Le mot de passe est obligatoire")
     */
    private $plainPassword;

    public function getId()
    {
        return $this->id;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * Transforme l'objet en chaîne de caractère normée
     */
    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->lastname,
            $this->firstname,
            $this->email,
            $this->password
        ]);
    }

    /**
     * Transforme une chaîne générée par serialize()
     * en objet
     * 
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->lastname,
            $this->firstname,
            $this->email,
            $this->password    
        ) = unserialize($serialized);
        
    }

    public function eraseCredentials() {
        
    }

    public function getRoles()
    {
        return [$this->role];
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function getFullname()
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }
    
    public function __toString()
    {
        return $this->getFullname();
    }
}
