<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\PersonneType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomPersonne')
            ->add('prenomPersonne')
            ->add('emailPersonne')
            ->add('telephone')
            ->add('adresse')
            ->add('personneType', EntityType::class, [
                'class' => PersonneType::class,
                'choice_label' => function ($personneType) {
                    return $personneType->getNomType();
                }
            ])
            ->add('submit', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
