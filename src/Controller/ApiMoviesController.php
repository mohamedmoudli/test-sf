<?php

namespace App\Controller;

use App\Entity\Movies;
use App\Repository\MoviesRepository;
use Doctrine\DBAL\Driver\IBMDB2\Driver;
use Doctrine\DBAL\Driver\PDO\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use FOS\RestBundle\Controller\Annotations as Rest;


class ApiMoviesController extends AbstractController
{

    #[Rest\Get('/api/movies', name: 'app_api_movies')]
    public function index(MoviesRepository $moviesRepository): Response
    {
     return $this->json($moviesRepository->findAll());
    }

}
