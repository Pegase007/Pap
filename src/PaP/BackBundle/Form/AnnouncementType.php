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
                'required'=> true,
                'placeholder'=>'Type',
                'choices'  => array('apt' => 'Appartment', 'hs' => 'House')
            ))
            ->add('energyLabel','choice', array(
                'required'=> true,
                'placeholder'=>'Label',
                'attr' => array('class' => 'select2 select2-primary'),
                'choices'  => array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G')
            ))
            ->add('surface')

            ->add('dateFrom', 'datetime', array(
                'input' => 'datetime',
                'widget' => 'single_text',
                'data' => new \DateTime("now")
                ))

            ->add('dateTo','date', array(
                'input'  => 'datetime',
                'widget' => 'choice',
                'placeholder' => array('day' => 'Day', 'month' => 'Month', 'year' => 'Year'),
                'format' => 'dd-MM-yyyy'
            ))
            ->add('nbrooms')
            ->add('bedrooms')
            ->add('pricePerMeterSquare')
            ->add('content')
            ->add('activate');


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
