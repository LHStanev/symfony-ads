<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\StringToImageTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    private $transformer;

    public function __construct(StringToImageTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('body', TextareaType::class)
            ->add('slug', TextType::class)
            ->add('image', FileType::class)
            ->add('Submit', SubmitType::class )
            ;

        $builder->get('image')
            ->addModelTransformer(new CallbackTransformer(
                function ($image) {
                    //When you edit a Form with a FileType
                    // the value should be empty (as you can't fill
                    // the value with the current one) so you would have
                    // to check if a new value is provided and update.
                    return null;
                },
                function ($image) {
                    // return the FileType
                    return $image;
                }
            ))
        ;

//        $builder->get('image')
//            ->addModelTransformer($this->transformer);

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Page'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_page';
    }


}
