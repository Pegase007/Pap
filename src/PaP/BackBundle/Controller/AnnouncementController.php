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

        $offers=$em->getRepository("BackBundle:Announcement")
            ->findAll();

        return $this->render("BackBundle:Announcement:index.html.twig",["offers"=>$offers]);

    }



    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $offers=$em->getRepository("BackBundle:Announcement")
            ->find($id);

        return $this->render("BackBundle:Announcement:show.html.twig",["offers"=>$offers]);

    }

    /**
     * Allows to create and Announcement
     *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        /**
         * Creation et traitement du formulaire
         */


//        $announcement=new Announcement();
//        $em=$this->getDoctrine()->getManager();
//        $formOffer=$this->createForm(new AnnouncementType($em),$announcement)
//            ->add("submit","submit");
//        $formOffer->handleRequest($request);
//        if($formOffer->isValid())
//        {
//            $em->persist($announcement);
//            $em->flush();
//            $this->get("session")->getFlashBag()
//                ->add("success","Your announcement has been creeated");
//
//            return $this->redirectToRoute("back_announcement_index");
//        }
//        return $this->render("BackBundle:Announcement:create.html.twig",["formOffer"=> $formOffer->createView()]);



        /**
         * Passer par un Handler pour traiter le formulaire
         */
        $formOffer = new AnnouncementHandler( $this->createForm(new AnnouncementType(),new Announcement()),$request);

        if($formOffer->process())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($formOffer->getForm()->getData());
            $em->flush();
            $this->get("session")->getFlashBag();
//                ->add("success","Your announcement has been creeated");
                return $this->redirectToRoute("back_announcement_index");

            }

        return $this->render("BackBundle:Announcement:create.html.twig",["formOffer"=> $formOffer->getForm()->createView()]);

    }


    /**
     * Allows to edit an announcement
     *
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $offer = $em->getRepository('BackBundle:Announcement')->find($id);




        if (!$offer) {
            throw $this->createNotFoundException('Unable to find announcement');
        }

        $editForm= $this->createForm(new AnnouncementType(),$offer)

            ->add("submit","submit");


        $editForm->handleRequest($request);

        if($editForm->isValid())
        {

            $em=$this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();


            $this->get("session")->getFlashBag()
                ->add("success","Your offer has been updated");

            return $this->redirectToRoute("back_announcement_index");

        }



        return $this->render('BackBundle:Announcement:edit.html.twig', ["editForm"=> $editForm->createView()]);

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
