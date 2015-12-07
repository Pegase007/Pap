<?php
namespace PaP\BackBundle\Form\Handler;


use Doctrine\ORM\EntityManager;
use PaP\BackBundle\Entity\Announcement;
use PaP\BackBundle\Form\AnnouncementType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementHandler

{

    protected $formfactory;
    protected $request;
    protected $em;
    protected $announcement;
    protected $form;



    /**
     * @param Form $form
     * @param Request $request
     * @param EntityManager $em
     */
    public function __construct(FormFactory $formfact, Request $request, EntityManager $em)
    {
        $this->formfactory = $formfact;
        $this->request= $request;
        $this->em= $em;

    }

    /**
     * Process checks that the form is valid
     *
     * @return bool
     */
    public function process(Announcement $offer)
    {

         $this->generateForm($offer);

        $this->form ->handleRequest($this->request);

        if($this->form->isValid())
        {

            $this->uploadAndStore();
            return true;

        }
        return false;


    }

    /**
     *
     * @return Form
     */
    public function getForm()
    {

        return $this->form;
    }

//    /**
//     *
//     * @return Form
//     */
//    public function setForm($form)
//    {
//        $this->form = $form;
//    }

    /*
     * Handle storing to database
     */
    protected function uploadAndStore()
    {

        $this->form->getData()->upload();

        $this->validate($this->form->getData());

    }




    public function generateForm(Announcement $offer)
    {

        $this->form = $this->formfactory->create(new AnnouncementType(), $offer);

    }

    public function activate(Announcement $offer, $action)
    {

        $announcement = $this->em->getRepository('BackBundle:Announcement')->find($offer);


        if($action == "activate")
        {

            $announcement->setActivate(1);

        }
        else
        {
            $announcement->setActivate(0);

        }

        $this->validate($announcement);


    }

    public function validate($validate)
    {

        $this->em->persist($validate);
        $this->em->flush();

    }






}