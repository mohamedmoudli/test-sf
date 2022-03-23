<?php

namespace App\Controller;

use App\Entity\Movies;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MoviesController extends AbstractController
{
    public function __construct( private HttpClientInterface $client){
        ;
    }
    #[Route('/email')]
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('mohamedmouldi95@gmail.com')
            ->to('mohamedmouldi95@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        return $this->json('success');
    }
    #[Route('/movies', name: 'app_movies')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/discover/movie?primary_release_date.lte=2022-03-22&api_key=c89646cb9c2f9f7a6144c074fff0e9c7'
        );
        $movies = $response->toArray()['results'];
        $i = 0;
        foreach ($movies as $mov){
            $i = $i + 1;
            $movie = new Movies();
            $movie->setAdult($mov['adult']);
            $movie->setBackdropPath($mov['backdrop_path']);
            $movie->setGenreIds($mov['genre_ids']);
            $movie->setIdMovies($mov['id']);
            $movie->setOriginalLanguage($mov['original_language']);
            $movie->setOriginalTitle($mov['original_title']);
            $movie->setOverview($mov['overview']);
            $movie->setPopularity($mov['popularity']);
            $movie->setPosterPath($mov['poster_path']);
            $movie->setReleaseDate(new \DateTime($mov['release_date']));
            $movie->setTitle($mov['title']);
            $movie->setVideo($mov['video']);
            $movie->setVoteAverage($mov['vote_average']);
            $movie->setVoteCount($mov['vote_count']);
            $entityManager->persist($movie);

        }
        $entityManager->flush();

        return $this->json('success') ;
    }
}
