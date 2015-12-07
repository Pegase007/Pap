<?php

namespace PaP\UserBundle\Controller;


use PaP\UserBundle\Entity\User;
use PaP\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * Routing through Framework extra bundle
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'UserBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );

    }


    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {

        $user= new User();

        $form=$this->createForm(new UserType(),$user);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like send them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('back_announcements');
        }

        return $this->render(
            'UserBundle:Register:register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/back/login_check", name="login_check")
     */
    public function loginCheckAction()
    {

        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/back/logout", name="logout")
     */
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }



}
