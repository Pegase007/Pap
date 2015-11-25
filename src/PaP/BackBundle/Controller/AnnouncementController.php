<?php

namespace PaP\BackBundle\Controller;

use PaP\BackBundle\Entity\Announcement;
use PaP\BackBundle\Form\AnnouncementType;
use PaP\BackBundle\Form\Handler\AnnouncementHandler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnnouncementController extends Controller

{
    /**
     *
     * Allows to see all Announcements
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $offers = $em->getRepository("BackBundle:Announcement")->getAllByCriteria();

        return $this->render("BackBundle:Announcement:index.html.twig",["offers" => $offers]);
    }


    /**
     *
     * 
     *
     * @param Announcement $offer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Announcement $offer)
    {

        return $this->render("BackBundle:Announcement:show.html.twig",["offer"=>$offer]);

    }

    /**
     * Allows to create and Announcement
     *
     * @TODO: both methods functions
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {

        $handler = $this->handler("Crée!", new Announcement());


        return $this->render("BackBundle:Announcement:create.html.twig",["formOffer"=> $handler->getForm()->createView()]);

    }


    protected function handler($message = "", $offer){
        $handler = $this->get('announcement_handler');
        $handler2 = $this->get('announcement_handler');


        $handler->setForm(false);
        (dump($handler));

        exit(dump($handler2));


        if($handler->process($offer))
        {

            $this->get("session")->getFlashBag()
                ->add("success",$message);
            return $this->redirectToRoute("back_announcement_index");

        }

        return $handler;
    }

    /**
     * Allows to edit an announcement
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Announcement $offer, Request $request)
    {

        $handler = $this->handler("Edité!", $offer);


        return $this->render('BackBundle:Announcement:edit.html.twig', ["editForm"=> $handler->getForm()->createView()]);

    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('BackBundle:Announcement')->find($id);

        if (!$offer) {
            throw $this->createNotFoundException('Unable to find announcement to delete.');
        }
//         Code de la suppression
        $em->remove($offer);
        $em->flush();


        if($request->isXmlHttpRequest())
        {

            return new JsonResponse();

        }

        $this->get("session")->getFlashBag()
            ->add("success","Your offer has been deleted");

        return $this->redirect($this->generateUrl("back_announcement_index"));

    }
}
