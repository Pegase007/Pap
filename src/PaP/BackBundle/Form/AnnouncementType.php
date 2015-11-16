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
            ->add('type','choice', array(
                'choices'  => array('apt' => 'Appartment', 'hs' => 'House')
            ))
            ->add('energyLabel')
            ->add('surface')
            ->add('nbrooms')
            ->add('bedrooms')
            ->add('pricePerMeterSquare')
            ->add('content')
            ->add('activate')
            ->add('created_at')
            ->add('updated_at')
            ->add('user', 'entity',[
                "expanded"=>true,
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
        return 'pap_backbundle_announcement';
    }
}
