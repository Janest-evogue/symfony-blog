<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/{id}")
     */
    public function index(Request $request, Article $article)
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
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $comment
                    ->setArticle($article)
                    ->setUser($this->getUser())
                ;
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                
                $this->addFlash('success', 'Votre commentaire est enregistré');
                
                // redirection sur la même page pour ne pas être en POST
                return $this->redirectToRoute(
                    // $request->get('_route') = la route de la page courante
                    $request->get('_route'),
                    [
                        'id' => $article->getId()
                    ]
                );
            }
        }
        
        return $this->render(
            'article/index.html.twig',
            [
                'article' => $article,
                'form' => $form->createView()
            ]
        );
    }
}
