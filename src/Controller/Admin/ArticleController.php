<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        // faire la page qui liste les articles
        // dans un tableau HTML avec nom de la catégorie
        // le nom de l'auteur et la date au format français
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Article::class);
        $articles = $repository->findAll();
        
        return $this->render(
            'admin/article/index.html.twig',
            [
                'articles' => $articles
            ]
        );
    }
    
    /**
     * @Route("/edition/{id}", defaults={"id": null})
     * @param Request $request
     */
    public function edit(Request $request, $id)
    {
        // Faire le rendu du formulaire et son traitement
        // Validation : tous les champs obligatoires
        // En création setter l'auteur avec l'utilisateur connecté
        // Pour avoir l'utilisateur connecté depuis un contrôleur :
        // $this->getUser()
        // Si enregistrement ok, rediriger vers la liste avec un
        // message de confirmation
        $em = $this->getDoctrine()->getManager();
        
        if (is_null($id)) {
            $article = new Article();
            $article->setAuthor($this->getUser());
        } else {
            $article = $em->find(Article::class, $id);
            
            if (is_null($article)) {
                throw new NotFoundHttpException();
            }
        }
        
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($article);
                $em->flush();
                
                $this->addFlash('success', "L'article est enregistré");
                return $this->redirectToRoute('app_admin_article_index');
            } else {
                $this->addFlash(
                    'error',
                    'Le formulaire contient des erreurs'
                );
            }
        }
        
        return $this->render(
            'admin/article/edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
    
    /**
     * @Route("/suppression/{id}")
     */
    public function delete(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        
        $this->addFlash(
            'success',
            'La catégorie est supprimée'
        );
        
        return $this->redirectToRoute('app_admin_article_index');
    }
}
