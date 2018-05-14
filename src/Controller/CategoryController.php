<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/{id}")
     */
    public function index(Category $category)
    {
        return $this->render(
            'category/index.html.twig',
            [
                'category' => $category
            ]
        );
    }
    
    public function menu()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Category::class);
        // en plus court :
        //$repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        
        return $this->render(
            'category/menu.html.twig',
            [
                'categories' => $categories
            ]
        );
    }
}
