<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/todo")]

class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response{
        // Afficher notre tableau de todo
        // si je n'ai pas alors je l'initialise puis l'affiche
        $session = $request->getSession();
        if(!$session->has('todos')){
            $todos = [
                "achat" => "acheter clé usb",
                "cours" => "Apprendre symfony",
                "correction" => "corriger exo",
            ];
            $session->set('todos', $todos);
        }
        // si tableau de todo dans la session je l'Affiche sinon initialisation puis afficher
        return $this->render('todo/index.html.twig');
        $this->addFlash("info", "La liste des todos viens d'être initialisée");
    }

    #[Route("/add/{name?test}/{content?ok}", name: 'todo.add',)]
    public function addTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        // vérifier si j'ai mon tableau de todo dans la session
        if($session->has("todos")){
            // si oui 
            // Vérifie si on a déjà un todo avec le même name 
            $todos = $session->get("todos");
            if(isset($todos[$name])){
                // si oui afficher erreur
                $this->addFlash("error", "La liste des todos $name existe déjà dans la liste");
            } else {
                // sinon on l'ajoute et on affiche un message de succès 
                $todos[$name] = $content;
                $session->set("todos", $todos);
                $this->addFlash("success", "La liste $name a été ajouté avec success");
            }
        } else {
            // si non
                // afficher une erreur et on va rediriger vers le controller index
            $this->addFlash("error" ,"La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute("todo");
    }   

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse{
        $session = $request->getSession();
        // vérifier si j'ai mon tableau de todo dans la session
        if($session->has("todos")){
            // si oui 
            // Vérifie si on a déjà un todo avec le même name 
            $todos = $session->get("todos");
            if(!isset($todos[$name])){
                // si oui afficher erreur
                $this->addFlash("error", "La todo $name n'existe pas dans la liste");
            } else {
                // sinon on l'ajoute et on affiche un message de succès 
                $todos[$name] = $content;
                $session->set("todos", $todos);
                $this->addFlash("success", "La todo $name a été modifié avec success");
            }
        } else {
            // si non
                // afficher une erreur et on va rediriger vers le controller index
            $this->addFlash("error" ,"La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute("todo");
    }   

    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse{
        $session = $request->getSession();
        // vérifier si j'ai mon tableau de todo dans la session
        if($session->has("todos")){
            // si oui 
            // Vérifie si on a déjà un todo avec le même name 
            $todos = $session->get("todos");
            if(!isset($todos[$name])){
                // si oui afficher erreur
                $this->addFlash("error", "La todo $name n'existe pas dans la liste");
            } else {
                // sinon on l'ajoute et on affiche un message de succès 
                unset($todos[$name]);
                $session->set("todos", $todos);
                $this->addFlash("success", "La todo $name a été supprimé avec success");
            }
        } else {
            // si non
                // afficher une erreur et on va rediriger vers le controller index
            $this->addFlash("error" ,"La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute("todo");
    }   

    #[Route('/reset', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse{

        $session = $request->getSession();
        $session->remove("todos");
            
        return $this->redirectToRoute("todo");
    }   
}
