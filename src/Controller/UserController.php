<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     /**
     * @Route("/user/register", name="user_register")
     */
    public function register(Request $request,UserPasswordEncoderInterface $encoder,
            EntityManagerInterface $em)
    {
        $user = new User();
        $form =  $this->createForm(RegisterType::class,$user);

        // bindea el request con el objeto user
        // $form->isValid Valida los datos con las anotaciones de Assert en el objeto
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
           $user->setRole("ROLE_USER");

           // Encriptar Password
           $encoded = $encoder->encodePassword($user, $user->getPassword());
           $user->setPassword($encoded);
           
           $em->persist($user);
           $em->flush();

           return $this->redirectToRoute('task');
        }

        
        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils){
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('user/login.html.twig', array(
            'error' => $error,
            'lastUserName' => $lastUserName
        ));

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }
}
