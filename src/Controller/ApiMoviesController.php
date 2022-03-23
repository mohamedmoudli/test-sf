<?php

namespace App\Controller;

use App\Core\Message\CreateUser;
use App\Core\Message\ShareMovie;
use App\Entity\Movies;
use App\Repository\MoviesRepository;
use Doctrine\DBAL\Driver\IBMDB2\Driver;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use FOS\RestBundle\Controller\Annotations as Rest;


class ApiMoviesController extends AbstractController
{
    public function __construct( private HttpClientInterface $client){
        ;
    }

    #[Rest\Get('/api/movies', name: 'app_api_movies')]
    public function index(MoviesRepository $moviesRepository): Response
    {
     return $this->json($moviesRepository->findAll());
    }
    #[Rest\Post('/api/share/movies', name: 'app_api_movies')]
    public function share(MoviesRepository $moviesRepository , Request $request , MessageBusInterface $bus): Response
    {
        $email = $request->request->get('email');
        $idMovie = $request->request->get('idMovie');
        $movie = $moviesRepository->findOneBy(['idMovie'=>$idMovie]);
        $bus->dispatch(new ShareMovie($email , $movie));
        return $this->json($moviesRepository->findAll());
    }

    #[Rest\Get('/api/movies/{id}', name: 'app_api_movies')]
    public function getMovie(MoviesRepository $moviesRepository ,int $id ): Response
    {
        $response = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/'.$id.'?api_key=c89646cb9c2f9f7a6144c074fff0e9c7'
        );
        $movie = $response->toArray()['results'];
        return $this->json($movie);
    }




}
