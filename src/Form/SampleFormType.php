<?php

namespace PrestaShop\Module\Kb_Config\Form;

use PrestaShop\Module\Kb_Config\Entity\SampleClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SampleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextareaType::class, ["label" => "Opis"])
            ->add('submit', SubmitType::class, ['label' => 'Wyślij']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SampleClass::class,
        ]);
    }
}
