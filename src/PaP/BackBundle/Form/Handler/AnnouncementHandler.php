<?php
namespace PaP\BackBundle\Form\Handler;


use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementHandler

{

    protected $form;
    protected $request;

    public function __construct(Form $form, Request $request)
    {
        $this->form=$form;
        $this->request=$request;

    }

    public function process()
    {

        $this->form->handleRequest($this->request);

        if($this->form->isValid())
        {

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



    }




}