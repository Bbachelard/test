<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields : 'email',message : "cette addresse existe deja")]
#[UniqueEntity(fields : 'username',message : "ce nom existe deja")]
class User implements UserInterface, PasswordAuthenticatedUserInterface,\Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique : true)]
    #[Assert\NotNull(message:"Vous devez indiquer un username valide")]
    #[Assert\Length(min: 3 ,max: 18,minMessage:"Votre username est trop court(minimun 3)",maxMessage:"Votre username est trop long(maximum 18)")]
    #[Assert\Regex(pattern: "/@/", match: false,message:"l'username {{value}} n'est pas valide")]
    private ?string $username = null;


    #[ORM\Column(length: 255, unique : true)]
    #[Assert\NotNull(message:"Vous devez indiquer une email valide.")]
    #[Assert\Email(message:"L'email indiquer n'est pas valide")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message:"Vous devez indiquer un mot de passe valide.")]
    private ?string $password = null;

    #[Assert\NotNull(message: "Vous devez indiquer une confirmation du mot de passe.")]
    //#[Assert\EqualTo(propertyPath:'password', message:'vos mot de passe ne sont pas identique')]
    private ?string $passwordConfirm =Null;

    #[ORM\Column(length: 255, unique : true)]
    #[Assert\Tel(options: ["defaultRegion" => "FR",  "onlyMobile" => true, "onlyEURoaming" => true])]
    private ?string $tel = null;



    #[ORM\Column]
    private array $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }



    public function getRoles(): array
    {
        $roles=$this->roles ;
        $roles[]= 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): static
    {
        $this->roles=$roles;
        return $this;
    }
    public function isAdmin()
    {
        return in_array('ROLE_ADMIN',$this->getRoles());
    }




    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->tel
        ));
    }
    public function unserialize($serialized):void
    {
        list(
            $this->id,
            $this->username,
            $this->email,
            $this->password,
            $this->tel
        )=unserialize($serialized);

    }
    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }
    public function setPasswordConfirm(string $passwordConfirm): static
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }
}
