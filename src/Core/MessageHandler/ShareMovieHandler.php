<?php
namespace App\Core\MessageHandler;

use App\Core\Message\ShareMovie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\SerializerInterface;


#[AsMessageHandler]
class ShareMovieHandler
{
    public function __construct( private  ManagerRegistry $doctrine ,private MailerInterface $mailer ){}

    public function __invoke(ShareMovie $message )
    {
        $entityManager = $this->doctrine->getManager();
        $email = (new Email())
            ->from('mohamedmouldi95@gmail.com')
            ->to($message->getContent())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
        $movie = $message->getMovie();
        $movie->setNbShare($movie->getNbShare()+1);
        $entityManager->merge($movie);
        $entityManager->flush();

        return $this->json('success');

    }

}