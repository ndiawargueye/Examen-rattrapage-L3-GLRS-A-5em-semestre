<?php
namespace App\Form;

use App\Entity\Employe;
use App\Entity\Departement;
use App\Entity\Poste;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class,  ['label' => 'Matricule'])
            ->add('nom',       TextType::class,  ['label' => 'Nom'])
            ->add('prenom',    TextType::class,  ['label' => 'Prenom'])
            ->add('email',     EmailType::class, ['label' => 'Email'])
            ->add('dateNaissance', DateType::class, [
                'label'  => 'Date de naissance',
                'widget' => 'single_text',
            ])
            ->add('genre', ChoiceType::class, [
                'label'   => 'Genre',
                'choices' => ['Masculin' => 'M', 'Feminin' => 'F'],
            ])
            ->add('departement', EntityType::class, [
                'label'        => 'Departement',
                'class'        => Departement::class,
                'choice_label' => 'nom',
                'required'     => false,
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
        $resolver->setDefaults(['data_class' => Employe::class]);
    }
}
