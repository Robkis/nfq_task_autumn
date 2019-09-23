<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use App\Entity\Staff;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('staff', EntityType::class, [
            	'class' => Staff::class,
            	'choice_label' => 'name',
            	'label' => 'Specialist ',
            ])
            ->add('save', SubmitType::class)
        ;
    }
}