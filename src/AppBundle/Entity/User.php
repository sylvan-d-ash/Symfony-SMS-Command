<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 * 
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User {
  /**
   * @var integer
   * 
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   * @ORM\Column(name="name", type="string", length=255)
   */
  protected $name;

  /**
   * @var string
   * @ORM\Column(name="email", type="string", length=255)
   */
  protected $email;

  /**
   * @var string
   * @ORM\Column(name="phone", type="string", length=255, nullable=true)
   */
  protected $phoneNumber;

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  public function getEmail() {
    return $this->email;
  }
  public function setEmail($email) {
    $this->email = $email;
    return $this;
  }

  public function getPhoneNumber() {
    return $this->phoneNumber;
  }
  public function setPhoneNumber($phoneNumber) {
    $this->phoneNumber = $phoneNumber;
    return $this;
  }
}