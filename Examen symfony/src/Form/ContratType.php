<?php
namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Poste;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeContrat', ChoiceType::class, [
                'label'   => 'Type de contrat',
                'choices' => ['CDI' => 'CDI', 'CDD' => 'CDD', 'Stage' => 'STAGE'],
            ])
            ->add('dateDebut', DateType::class, [
                'label'  => 'Date debut',
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateType::class, [
                'label'    => 'Date fin (vide si CDI)',
                'widget'   => 'single_text',
                'required' => false,
            ])
            ->add('salaireBase', NumberType::class, ['label' => 'Salaire de base'])
            ->add('periodeEssai', CheckboxType::class, [
                'label'    => 'Periode d\'essai',
                'required' => false,
            ])
            ->add('poste', EntityType::class, [
                'label'        => 'Poste',
                'class'        => Poste::class,
                'choice_label' => 'intitule',
                'required'     => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Contrat::class]);
    }
}
