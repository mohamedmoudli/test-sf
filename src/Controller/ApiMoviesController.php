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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
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

    #[Rest\Get('/api/share/movies/{id}', name: 'share_movies')]
    public function share( MessageBusInterface $bus , Movies $movie): Response
    {
        $body = $this->renderView('email/details_movie.html.twig',
            [ 'movie'=>$movie ]
        );
        $bus->dispatch(new ShareMovie($body , $movie));
        return $this->json('success');
    }

    #[Rest\Get('/api/movies/{id}', name: 'get_movies')]
    public function getMovie(int $id  ,MessageBusInterface $bus , ParameterBagInterface $params): Response
    {
        $response = $this->client->request(
            'GET',
            $params->get('domain_api').'/3/movie/'.$id.'?api_key='.$params->get('api_key')
        );
        $movie = $response->toArray();
        return $this->json($movie);
    }




}
