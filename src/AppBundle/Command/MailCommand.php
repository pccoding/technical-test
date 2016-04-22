<?php
/**
 * Created by PhpStorm.
 * User: razvanp
 * Date: 22/04/2016
 * Time: 12:03
 */

namespace AppBundle\Command;

use AppBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('demo:processEmails')
            ->setDescription('Process mysql Mails');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {

            //$name = $input->getArgument('name');
            /** @var \AppBundle\Services\MailService $mailer*/
            $mailer = $this->getContainer()->get('app.mailer');
            $doctrine = $this->getContainer()->get('doctrine');

            // TODO - extract statuses into constants
            $mails = $doctrine->getRepository('AppBundle:Mail')
                ->findBy(['status' => 'waiting']);
            // TODO - implement limits
            if ($mails) {
                /** @var Mail $mail */
                foreach ($mails as $mail) {
                    // TODO - extract into a method
                    $mail->setStatus('processing');
                    $doctrine->persist($mail);
                    $doctrine->flush();

                    $response  = $mailer->send($mail);
                    if($response) {
                        // TODO - remove
                        $doctrine->remove($mail);
                    } else {
                        // TODO - update failed status
                    }
                }
            }

        } catch (\Exception $e) {
            // log error
        }
        $text = "process command has been executed";
        $output->writeln($text);



    }
}