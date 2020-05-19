<?php

namespace App\Form;

use App\Entity\PhoneBook;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('phone')
            ->add('users', EntityType::class, [
                'class'         =>      'App\Entity\User',
                'choice_label'  =>      'username',
                'label'         =>      'Users that can use this.',
                'expanded'      =>      true,
                'multiple'      =>      true,
                'by_reference'  =>      false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PhoneBook::class,
        ]);
    }
}
