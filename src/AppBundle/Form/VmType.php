<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\User;
use AppBundle\Entity\Pool;

class VmType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('os')->add('nbcpu')/*->add('currentCpu')->add('currentRam')*/->add('maxRam')->add('harddisk')
        /*->add('currentharddisk')->add('user', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'login'])*/
            ->add('pool', EntityType::class, [
                'class' => Pool::class,
                'choice_label' => 'name',
                ]
                
            );
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vm'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_vm';
    }


}
