<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Repository\MoviesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MoviesController extends AbstractController
{
    public function __construct( private HttpClientInterface $client){

    }
    #[Route('/movies', name: 'app_movies')]
    public function index(ManagerRegistry $doctrine , ParameterBagInterface $params): Response
    {

        $entityManager = $doctrine->getManager();
        $response = $this->client->request(
            'GET',
            $params->get('domain_api').'/3/discover/movie?primary_release_date.lte='.date('Y-m-d').'&api_key='.$params->get('api_key')
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
            $movie->setNbShare(0);
            $entityManager->persist($movie);

        }
        $entityManager->flush();

        return $this->json('success') ;
    }

    #[Route('/list/movies', name: 'index_movies')]
    public function movies(MoviesRepository $moviesRepository): Response
    {
        $firstMovies = $moviesRepository->findMovies();
        $movies = $moviesRepository->findAll();
        return $this->render('movies/index.html.twig', [
            'movies'=>$movies ,
            'firstMovies'=>$firstMovies
        ]);
    }

    #[Route('/movies/{id}', name: 'show_movies')]
    public function show( Movies $movie  , ParameterBagInterface $params): Response
    {
        $response = $this->client->request(
            'GET',
            $params->get('domain_api').'/3/movie/'.$movie->getIdMovies().'/credits?api_key='.$params->get('api_key')
        );
        $actors = $response->toArray();
        $actors = $actors['cast'];
        return $this->render('movies/show.html.twig', [
            'movie'=>$movie ,
            'actors'=>$actors
        ]);
    }

}
