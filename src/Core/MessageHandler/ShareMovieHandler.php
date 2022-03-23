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
            ->to('mohamedmouldi95@gmail.com')
            ->subject('Details Films')
            ->text('Details Films')
            ->html($message->getContent());

        $this->mailer->send($email);
        $movie = $message->getMovie();
        $movie->setNbShare($movie->getNbShare()+1);
        $entityManager->merge($movie);
        $entityManager->flush();


    }

}