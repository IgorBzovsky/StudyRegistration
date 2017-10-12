<?php

namespace AutoBundle\Form;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('year')->add('isActive')->add('createdAt')->add('updatedAt')->add('make')->add('model')->add('body')->add('createdBy');
        $builder->add('year', \Symfony\Component\Form\Extension\Core\Type\DateType::class,
            array('widget' => 'single_text'))->add('make')->add('model')->add('body');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AutoBundle\Entity\Car'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'autobundle_car';
    }


}
