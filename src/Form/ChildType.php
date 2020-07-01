<?php

namespace App\Form;

use App\Entity\Child;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', TextType::class, [
                'label' => 'Photo',
                'attr' => [
                    'placeholder' => "Url de l'image"
                ],
                'required' => \false
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom de famille',
                'attr' => [
                    'placeholder' => "Nom"
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => "Prénom"
                ]
            ])
            ->add('genre')
            ->add('dateNaissance')
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse postale'
                ]
            ])
            ->add('codePostal')
            ->add('ville')
            ->add('securiteSociale')
            ->add('numeroCaf')
            ->add('assuranceScolaire')
            ->add('nombreFreres')
            ->add('nombreSoeurs')
            ->add('professionMere')
            ->add('professionPere')
            ->add('telephoneDomicile')
            ->add('telephonePere')
            ->add('telephoneMere')
            ->add('observations')
            ->add('nomMedecinTraitant')
            ->add('telephoneMedecin');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}
