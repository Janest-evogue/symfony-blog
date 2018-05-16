<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le titre est obligatoire")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le contenu est obligatoire")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $publicationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="La catégorie est obligatoire")
     * @var Category
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $author;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Image()
     * @var string
     */
    private $image;

    /**
     * les commentaires liés à l'article
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article", cascade={"remove"})
     * Pour choisir l'ordre de tri par défaut :
     * @ORM\OrderBy({"publicationDate" = "DESC"})
     */
    private $comments;
    
    public function __construct()
    {
        $this->publicationDate = new DateTime();
    }

    
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }
    
    public function getCategory() {
        return $this->category;
    }

    public function getAuthor(): User {
        return $this->author;
    }

    public function setCategory(Category $category) {
        $this->category = $category;
        return $this;
    }

    public function setAuthor(User $author) {
        $this->author = $author;
        return $this;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    public function getComments(): Collection {
        return $this->comments;
    }

    public function setComments(Collection $comments) {
        $this->comments = $comments;
        return $this;
    }


}
