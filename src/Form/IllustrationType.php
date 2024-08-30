<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Illustration;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IllustrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('illustration', FileType::class,[
                'mapped' => false,
                'required' => false])
            ->add('thumbnail', FileType::class,[
                'mapped' => false,
                'required' => false])
            ->add('name')
            ->add('description')
            /*->add('limitAge')
            ->add('price')
            ->add('views')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            */
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Illustration::class,
        ]);
    }
}
