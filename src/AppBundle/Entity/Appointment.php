<?php
namespace AppBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Appointment
 * 
 * @ORM\Entity
 * @ORM\Table(name="appointment")
 */
class Appointment {
  /**
   * @var integer
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var User
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
   */
  protected $user;

  /**
   * @var \DateTime
   * @ORM\Column(name="date", type="datetime")
   */
  protected $date;

  public function getId() {
    return $this->id;
  }

  public function getUser() {
    return $this->user;
  }
  public function setUser(User $user) {
    $this->user = $user;
    return $this;
  }

  public function getDate() {
    return $this->date;
  }
  public function setDate(\DateTime $date) {
    $this->date = $date;
    return $this;
  }
}