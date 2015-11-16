<?php

namespace PaP\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OptionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title')
            ->add('announcement','entity', array(
                "multiple"=>true,
                'class' => 'BackBundle:Announcement',
                'choice_label' => 'title',
                'by_reference'=>false,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PaP\BackBundle\Entity\Options'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pap_backbundle_options';
    }
}




