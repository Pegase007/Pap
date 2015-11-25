<?php

namespace PaP\BackBundle\Form;

use PaP\BackBundle\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('price')
            ->add('ref')
            ->add('address')
            ->add('city')
            ->add('cp')
            ->add('country')
            ->add('file', 'file', array('attr' => array('accept' => 'image/*')))
            ->add('type','choice', array(
                'choices'  => array('apt' => 'Appartment', 'hs' => 'House')
            ))
            ->add('energyLabel','choice', array(
                'choices'  => array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G',)
            ))
            ->add('surface')
            ->add('nbrooms')
            ->add('bedrooms')
            ->add('pricePerMeterSquare')
            ->add('content')
            ->add('activate')
            ->add('user', 'entity',[
                "expanded"=>false,
                'class' => 'BackBundle:User',
                'choice_label' => 'pseudo',

            ]);


//           ->add('options', new OptionsType());

    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PaP\BackBundle\Entity\Announcement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'announcement_form';
    }
}
