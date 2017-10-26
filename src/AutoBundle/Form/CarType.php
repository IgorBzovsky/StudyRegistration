<?php

namespace AutoBundle\Form;

use Comur\ImageBundle\Form\Type\CroppableImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $car = $builder->getForm()->getData();
        //$builder->add('year')->add('isActive')->add('createdAt')->add('updatedAt')->add('make')->add('model')->add('body')->add('createdBy');
        $builder->add('year', \Symfony\Component\Form\Extension\Core\Type\DateType::class,
            [
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
                'format' => 'yyyy'
            ])->add('make', EntityType::class, [
                'class' => 'AutoBundle:Make',
                'attr' => ['class' => 'js-make']
            ])->add('model', EntityType::class, [
                'class' => 'AutoBundle:Model',
                'attr' => ['class' => 'js-model']
            ])->add('body', EntityType::class, [
                'class' => 'AutoBundle:Body'
            ])->add('isActive')
              ->add('image', CroppableImageType::class, array(
                  'uploadConfig' => array(
                      'uploadRoute' => 'comur_api_upload',
                      'uploadUrl' => $car->getUploadRootDir(),
                      'webDir' => $car->getUploadDir(),
                      'fileExt' => '*.jpg;*.gif;*.png;*.jpeg',
                      'libraryDir' => null,
                      'libraryRoute' => 'comur_api_image_library',
                      'showLibrary' => false,
                      'saveOriginal' => 'originalImage',
                      'generateFilename' => true
                  ),
                  'cropConfig' => array(
                      'minWidth' => 240,
                      'minHeight' => 200,
                      'aspectRatio' => true,
                      'cropRoute' => 'comur_api_crop',
                      'forceResize' => false,
                      'thumbs' => array(
                          array(
                              'maxWidth' => 180,
                              'maxHeight' => 150,
                              'useAsFieldImage' => true
                          ),
                          array(
                              'maxWidth' => 240,
                              'maxHeight' => 200,
                              'useAsFieldImage' => true
                          )
                      )
                  )
              ))
              ->add('price', MoneyType::class, array(
                'currency' => 'USD'
            ))->add('description', TextareaType::class,
            [
                'attr' => ['required' => 'false']
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AutoBundle\Entity\Car',
            'makes' => null
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
