<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $builder
            ->add('name', TextType::class, [
                'label' => ' ', 
                'attr' => array('placeholder' => 'Nom du produit')
            ])
            ->add('price', MoneyType::class, [
                'label' => ' ',
                'attr' => array('placeholder' => 'Prix')
            ])
            ->add('description', TextareaType::class,[
            'label' => ' ',
            'attr' => array('placeholder' => 'Description')
            ])
            ->add('category', EntityType::class, [
                'label' => ' ',
                'class' => Category::class,
                'choice_label' => 'category'
            ])
            ->add('imageFile', FileType::class, [
                'label' => ' ',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/gif',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Le fichier doit être un jpg, gif, png ou un webp',
                    ])
                ]                                
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
