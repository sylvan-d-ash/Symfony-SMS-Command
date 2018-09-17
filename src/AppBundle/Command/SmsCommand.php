<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use \Twilio\Rest\Client;

class SmsCommand extends ContainerAwareCommand {
  private $twilio;

  public function __construct(Client $twilio) {
    $this->twilio = $twilio;

    parent::__construct();
  }

  protected function configure() {
    $this->setName('myapp:sms')
         ->setDescription('Send reminder text message');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $em = $this->getContainer()->get('doctrine');
    $userRepository = $em->getRepository('AppBundle:User');
    $appointmentRepository = $em->getRepository('AppBundle:Appointment');
    //$twilio = $this->getContainer()->get('twilio.client');

    $start = new \DateTime();
    $start->setTime(00, 00);
    $end = clone $start;
    $end->modify('+1 days');
    $output->writeln('START: ' . $start->format('Y-m-d H:i'));
    $output->writeln('END: ' . $end->format('Y-m-d H:i'));

    // get appointments scheduled for today
    $appointments = $appointmentRepository->createQueryBuilder('a')
      ->select('a')
      ->where('a.date BETWEEN :now AND :end')
      ->setParameters(array(
        'now' => $start,
        'end' => $end,
      ))
      ->getQuery()
      ->getResult();
    
    if (count($appointments) > 0) {
      $output->writeln('SMSes to send: #' . count($appointments));

      $sender = $this->getContainer()->getParameter('twilio_number');
      foreach ($appointments as $appoint) {
        $user = $appoint->getUser();
        $message = $this->twilio->messages->create(
          $user->getPhoneNumber(), // Send text to this number
          array(
            'from' => $sender,
            'body' => 'Hello from Awesome Massages. A reminder that your massage appointment is for today at ' . $appoint->getDate()->format('H:i') . '. Call ' . $sender . ' for any questions.'
          )
        );

        $output->writeln('SMS #' . $message->sid . ' sent to: ' . $user->getPhoneNumber());
      }
      
    } else {
      $output->writeln('No appointments for today.');
    }
  }
}