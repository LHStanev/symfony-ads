<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('body', TextType::class)
            ->add('price', NumberType::class)
            ->add('image', FileType::class)
            ->add('isActive')
            ->add('dateCreated', DateType::class)
            ->add('dateExpires', DateType::class)
            ->add('category', EntityType::class, [
                'class' =>Category::class,
                'choice_label' => 'name'
            ])
            ->add('location', EntityType::class, [
                'class' =>Location::class,
                'choice_label' => 'name'
            ])
            ->add('Submit', SubmitType::class);

        $builder->get('image')
            ->addModelTransformer(new CallbackTransformer(
                function ($image) {
                    return null;
                },
                function ($image) {
                    // return the FileType
                    return $image;
                }
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_ad';
    }


}
