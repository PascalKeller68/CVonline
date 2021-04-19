<?php

namespace App\Form;

use App\Entity\ProjectLanguages;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormProjectLanguageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('languageName', TextType::class, ['attr' => ['label' => 'Nom du langage'],])
            ->add('languageUse', IntegerType::class, ['attr' => ['label' => 'du langage'],]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectLanguages::class,
        ]);
    }
}
