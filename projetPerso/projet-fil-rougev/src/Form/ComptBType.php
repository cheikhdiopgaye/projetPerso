<?php

namespace App\Form;

use App\Entity\CompteBancaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Partenaires;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ComptBType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          //  ->add('numeroCompte')
          //  ->add('solde')
            ->add('partenaire', EntityType::class, [
                'class'=>Partenaires::class, 'choice_label' => 'raisonSocial'
            ])
           // ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompteBancaire::class,
        ]);
    }
}
