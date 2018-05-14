<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                // nom du champ qui doit correspondre 
                // au nom de l'attribut dans l'entité Category
                'name',
                // type de champ
                TextType::class, // input type="text"
                // tableau d'options
                [
                    // contenu de la balise label
                    'label' => 'Nom',
                    // si l'on veut ajouter une classe à l'input
                    'attr' => [
                        'class' => 'test'
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
