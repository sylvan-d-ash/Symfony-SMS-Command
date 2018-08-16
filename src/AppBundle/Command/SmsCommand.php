<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SmsCommand extends ContainerAwareCommand {
  protected function configure() {
    $this->setName('myapp:sms')
         ->setDescription('Send reminder text message');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $em = $this->getContainer()->get('doctrine');
    $userRepository = $em->getRepository('AppBundle:User');
    $appointmentRepository = $em->getRepository('AppBundle:Appointment');

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
    } else {
      $output->writeln('No appointments for today.');
    }
  }
}