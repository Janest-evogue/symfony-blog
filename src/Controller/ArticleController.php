<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/{id}")
     */
    public function index(Article $article)
    {
        // faire la page qui affiche toutes les informations
        // de l'article ici et ajouter le liens sur les titres
        // d'articles des pages catégorie
        
        /*
         * - Si on a un utilisateur connecté afficher
         * un formulaire de commentaire avec juste un textarea
         * pour le contenu, sinon afficher un message pour
         * l'inviter à se connecter.
         * Setter l'auteur et l'article du commentaire
         * avec l'utilisateur connecté et l'article de la page
         * 
         * - Lister les commentaires de l'article en dessous
         */
        
        return $this->render(
            'article/index.html.twig',
            [
                'article' => $article
            ]
        );
    }
}
