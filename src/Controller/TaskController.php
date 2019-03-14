<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskType;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{    
     /**
     * @Route("/task", name="task")
     */
    public function tasks(EntityManagerInterface $em)
    {
        $taskRepository = $this->getDoctrine()->getRepository(Task::class);

        $tasks = $taskRepository->findBy([], ['id' => 'DESC']);
       
        return $this->render('task/index.html.twig', [            
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/task/user", name="taskByUser")
     */
    public function myTasks(UserInterface $user)
    {        
        $tasks = $user->getTasks();
       
        return $this->render('task/my-tasks.html.twig', [            
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/task/detail/{id}", name="taskDetail")
     */
    public function tasksDetail(Task $task = null)
    {   
        if(!$task)
        {
            return $this->redirectToRoute('task');
        }
        return $this->render('task/taskDetail.html.twig', [            
            'task' => $task
        ]);
    }

    /**
     * @Route("/task/create", name="taskCreate")
     */
    public function tasksCreate(Request $request, EntityManagerInterface $em,
                        UserInterface $user=null)
    {  
        if(!$user ){
            return  $this->redirectToRoute('task');            
        }

        $task = new Task();
        $form =  $this->createForm(TaskType::class,$task);

        // bindea el request con el objeto user
        // $form->isValid Valida los datos con las anotaciones de Assert en el objeto
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $task->setUser($user);
            $em->persist($task);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('taskDetail', ['id' => $task->getId()])
            );
        }
        return $this->render('task/taskCreate.html.twig', [            
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/task/edit/{id}", name="taskEdit")
     */
    public function taskEdit(Request $request, EntityManagerInterface $em,
                        Task $task,UserInterface $user=null)
    {          
        if(!$task || !$user || $user->getId() != $task->getUser()->getId()){
            return  $this->redirectToRoute('task');            
        }

        $form =  $this->createForm(TaskType::class,$task);

        // bindea el request con el objeto user
        // $form->isValid Valida los datos con las anotaciones de Assert en el objeto
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {           
            $em->persist($task);
            $em->flush();
            return $this->redirect(
                $this->generateUrl('taskDetail', ['id' => $task->getId()])
            );
        }
        return $this->render('task/taskCreate.html.twig', [            
            'form' => $form->createView(),
            'edit' => true,
            'task' => $task
        ]);
    }

     /**
     * @Route("/task/delete/{id}", name="taskDelete")
     */
    public function taskDelete(Request $request, EntityManagerInterface $em,
                        Task $task,UserInterface $user=null)
    {          
        if(!$task || !$user || $user->getId() != $task->getUser()->getId()){
            return  $this->redirectToRoute('task');            
        }

        $em->remove($task);
        $em->flush();
        return  $this->redirectToRoute('task');
    }
}
