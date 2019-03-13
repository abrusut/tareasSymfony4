<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends AbstractController
{
    /**
     * @Route("/", name="index_task")
     */
    public function index(EntityManagerInterface $em)
    {   
        return $this->tasks($em);
    }

    /**
     * @Route("/task", name="task")
     */
    public function tasks(EntityManagerInterface $em)
    {
        $taskRepository = $this->getDoctrine()->getRepository(Task::class);

        $tareas = $taskRepository->findAll();

        foreach($tareas as $tarea)
        {
          //  echo $tarea->getUser()->getEmail()." : ".$tarea->getTitle()."<br/>";
        }


        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $usuarios = $userRepository->findAll();
        foreach($usuarios as $usuario)
        {
           // echo "<h3> {$usuario->getName()} {$usuario->getSurName()} </h3>";
            
            foreach($usuario->getTasks() as $tarea)
            {
             //    echo $tarea->getTitle()."<br/>";
            }
            
        }

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
