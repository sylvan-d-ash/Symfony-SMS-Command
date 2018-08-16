<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use AppBundle\Entity\Appointment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture {
  public function load(ObjectManager $manager) {
    // our information array
    $usersInfo = [
      [
        'name' => 'Jon snow',
        'email' => 'jon.snow@thewatch.com',
        'phone' => '+1231234567890',
        'date' => '16-08-2018 13:00'
      ],
      [
        'name' => 'Arya Stark',
        'email' => 'arya.star@winterfell.com',
        'phone' => '+1230987654321',
        'date' => '16-08-2018 15:00'
      ],
      [
        'name' => 'Tyrion Lannister',
        'email' => 'tyrion.lannister@casterlyrock.com',
        'phone' => '+1234567890123',
        'date' => '17-08-2018 15:00'
      ]
      ];

      // loop through our array and create our users + their appointments
      foreach ($usersInfo as $info) {
        // create user
        $user = new User();
        $user->setName($info['name']);
        $user->setEmail($info['email']);
        $user->setPhoneNumber($info['phone']);
        $manager->persist($user);

        // get a date object from out date string
        $date = date_create_from_format('d-m-Y H:i', $info['date']);

        // create appointment for the user
        $appointment = new Appointment();
        $appointment->setDate($date);
        $appointment->setUser($user);
        $manager->persist($appointment);
      }

      $manager->flush();
  }
}