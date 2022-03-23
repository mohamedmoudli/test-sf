<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $adult;

    #[ORM\Column(type: 'string', length: 255)]
    private $backdropPath;

    #[ORM\Column(type: 'array')]
    private $genreIds = [];

    #[ORM\Column(type: 'integer')]
    private $idMovies;

    #[ORM\Column(type: 'string', length: 255)]
    private $originalLanguage;

    #[ORM\Column(type: 'string', length: 255)]
    private $originalTitle;

    #[ORM\Column(type: 'text')]
    private $overview;

    #[ORM\Column(type: 'float')]
    private $popularity;

    #[ORM\Column(type: 'string', length: 255)]
    private $posterPath;

    #[ORM\Column(type: 'date')]
    private $releaseDate;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'boolean')]
    private $video;

    #[ORM\Column(type: 'float')]
    private $voteAverage;

    #[ORM\Column(type: 'integer')]
    private $voteCount;

    #[ORM\Column(type: 'integer')]
    private $nbShare;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdult(): ?bool
    {
        return $this->adult;
    }

    public function setAdult(bool $adult): self
    {
        $this->adult = $adult;

        return $this;
    }

    public function getBackdropPath(): ?string
    {
        return $this->backdropPath;
    }

    public function setBackdropPath(string $backdropPath): self
    {
        $this->backdropPath = $backdropPath;

        return $this;
    }

    public function getGenreIds(): ?array
    {
        return $this->genreIds;
    }

    public function setGenreIds(array $genreIds): self
    {
        $this->genreIds = $genreIds;

        return $this;
    }

    public function getIdMovies(): ?int
    {
        return $this->idMovies;
    }

    public function setIdMovies(int $idMovies): self
    {
        $this->idMovies = $idMovies;

        return $this;
    }

    public function getOriginalLanguage(): ?string
    {
        return $this->originalLanguage;
    }

    public function setOriginalLanguage(string $originalLanguage): self
    {
        $this->originalLanguage = $originalLanguage;

        return $this;
    }

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    public function setOriginalTitle(string $originalTitle): self
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function getPopularity(): ?float
    {
        return $this->popularity;
    }

    public function setPopularity(float $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->posterPath;
    }

    public function setPosterPath(string $posterPath): self
    {
        $this->posterPath = $posterPath;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVideo(): ?bool
    {
        return $this->video;
    }

    public function setVideo(bool $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getVoteAverage(): ?float
    {
        return $this->voteAverage;
    }

    public function setVoteAverage(float $voteAverage): self
    {
        $this->voteAverage = $voteAverage;

        return $this;
    }

    public function getVoteCount(): ?int
    {
        return $this->voteCount;
    }

    public function setVoteCount(int $voteCount): self
    {
        $this->voteCount = $voteCount;

        return $this;
    }

    public function getNbShare(): ?int
    {
        return $this->nbShare;
    }

    public function setNbShare(int $nbShare): self
    {
        $this->nbShare = $nbShare;

        return $this;
    }
}
