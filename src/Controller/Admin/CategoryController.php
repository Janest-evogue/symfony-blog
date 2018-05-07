<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Category::class);
        $categories = $repository->findAll();
        // Si on veut trier par id :
        // $categories = $repository->findBy([], ['id' => 'asc']);
        
        return $this->render(
            'admin/category/index.html.twig',
            [
                'categories' => $categories
            ]
        );
    }
    
    /**
     * @Route("/edition/{id}", defaults={"id": null})
     */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        if (is_null($id)) { // création
            $category = new Category();
        } else { // modification
            $category = $em->find(Category::class, $id);
            
            // 404 si l'id reçu dans l'URL n'existe pas en bdd
            if (is_null($category)) {
                throw new NotFoundHttpException();
            }
        }
        
        // création d'un formulaire relié à la catégorie
        $form = $this->createForm(CategoryType::class, $category);
        // le formulaire analyse la requête HTTP
        $form->handleRequest($request);
        
        // si le formulaire a été envoyé
        if ($form->isSubmitted()) {
            // les attributs de l'objet Catégory ont été
            // settés à partir des champs de formulaires
            //dump($category);
            
            // Valide la saisie du formulaire à partir
            // des annotations dans la classe Category
            if ($form->isValid()) {

                // enregistrement en bdd
                $em->persist($category);
                $em->flush();
                
                // message de confirmation
                $this->addFlash(
                    'success',
                    'La catégorie est enregistrée'
                );
                // redirection vers la page de liste
                return $this->redirectToRoute('app_admin_category_index');
            } else {
                // message d'erreur en haut de la page
                $this->addFlash(
                    'error',
                    'Le formulaire contient des erreurs'
                );
            }
        }
        
        return $this->render(
            'admin/category/edit.html.twig',
            [
                // passage du formulaire à la vue
                'form' => $form->createView()
            ]
        );
    }
}
