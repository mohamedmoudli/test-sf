<?php
namespace App\Core\Message;

use App\Entity\Movies;

class ShareMovie
{


    public function __construct(private string $content ,private Movies $movies)
    {

    }

    public function getContent(): string
    {
        return $this->content;
    }
    public function getMovie(): Movies
    {
        return $this->movies;
    }
}
