<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' , TextType::class, ['required' => true, 'attr' => ['placeholder' => 'LastName']])
            ->add('date' ,
                DateType::class,
                [
                    'widget' => 'single_text',
                    'required' => true, ])
            ->add('text' , TextType::class, ['required' => true, 'attr' => ['placeholder' => 'LastName']])
            ->add('imageFile' , VichImageType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
