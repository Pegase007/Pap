<?php
namespace PaP\BackBundle\Form\Handler;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementHandler

{

    protected $form;
    protected $request;
    protected $em;

    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form=$form;
        $this->request=$request;
        $this->em= $em;

    }

    public function process()
    {

        $this->form->handleRequest($this->request);

        if($this->form->isValid())
        {

            $this->onSuccess();
            return true;

        }
        return false;


    }

    public function getForm()
    {

        return $this->form;
    }

    protected function onSuccess()
    {



        $this->em->persist($this->form->getData());
//            die;
        $this->em->flush();


    }

    public function createView()
    {

        return $this->form->createView();
    }







}