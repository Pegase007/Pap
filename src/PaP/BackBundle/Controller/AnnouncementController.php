<?php

namespace PaP\BackBundle\Controller;

use PaP\BackBundle\Entity\Announcement;
use PaP\BackBundle\Entity\Comments;
use PaP\BackBundle\Form\AnnouncementType;
use PaP\BackBundle\Form\CommentsType;
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

        return $this->render("BackBundle:Announcement:index.html.twig", ["offers" => $offers]);
    }


    /**
     *
     *
     *
     * @param Announcement $offer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Request $request, Announcement $offer)

    {

        $em = $this->getDoctrine()->getManager();
        $lastComments = $em->getRepository("BackBundle:Comments")
            ->lastComments($offer);

        $comments = new Comments();

        $comments->setAnnouncement($offer);


        $formComments = $this->createForm(new CommentsType(), $comments);


        $formComments->handleRequest($request);

        if ($formComments->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($comments);
            $em->flush();


            $this->get("session")->getFlashBag()
                ->add("success", "Le commentaire à été crée");

//                Get to Post permet de transformer les formulaire qui arrive en post -> get()
            return $this->redirectToRoute("back_announcement_show", ["offer" => $offer->getId()]);


        }


        return $this->render("BackBundle:Announcement:show.html.twig", [
            "offer" => $offer,
            "formComments" => $formComments->createView(),
            "lastComments" => $lastComments
        ]);

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

        return $this->handler("Crée!", new Announcement());


    }


    protected function handler($message = "", $offer, $view = "create")
    {

        $handler = $this->get('announcement_handler');

        if ($handler->process($offer)) {

            return $this->redirectToRoute("back_announcement_index");

        }

        return $this->render("BackBundle:Announcement:{$view}.html.twig",
            ["form" => $handler->getForm()->createView(), "offer" => $offer]);


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

        return $this->handler("Edite!", $offer, "edit");


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


        if ($request->isXmlHttpRequest()) {

            return new JsonResponse();

        }

        $this->get("session")->getFlashBag()
            ->add("success", "Your offer has been deleted");

        return $this->redirect($this->generateUrl("back_announcement_index"));

    }


    public function activateAction($id,$action, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $announcement = $em->getRepository('BackBundle:Announcement')->find($id);


        if($action == "activate")
        {

            $announcement->setActivate(1);

        }
        else
        {
            $announcement->setActivate(0);

        }

        $em->persist($announcement);
        $em->flush();

        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse([]);
        }

        return $this->redirectToRoute("back_announcement_index");

    }


}
