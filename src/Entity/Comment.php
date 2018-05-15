<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publicationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(nullable=false)
     * @var Article 
     */
    private $article;
    
    public function __construct()
    {
        $this->publicationDate = new \DateTime();
    }

    
    public function getId()
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function getArticle() {
        return $this->article;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setArticle(Article $article) {
        $this->article = $article;
        return $this;
    }


}
