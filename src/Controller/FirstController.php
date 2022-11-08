<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FirstController extends AbstractController
{

    #[Route("/order/{maVar}", name : "test.order.route")]
    public function testOrderRoute($maVar){
        return new Response("
        <html><body>$maVar</body></html>
        ");
    }

    #[Route('/first', name: 'first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'name' => 'Billy',
            'firstName' => 'Boll',
        ]);
    }

    // #[Route('/sayHello/{name}/{firstName}', name: 'say.hello')]
    public function sayHello($name, $firstName): Response
    {
        return $this->render("first/hello.html.twig", [
            "firstName" => $firstName,
            "name" => $name,
        ]);
    }

    #[Route("/multiplication/{nb1<\d+>}/{nb2<\d+>}", name: 'multiplication')]
    public function multiplication(int $nb1, int $nb2)
    {
        $resultat = $nb1 * $nb2;
        return new Response("<h1>$resultat</h1>");
    }

    #[Route("/template", name: 'template')]
    public function template()
    {
        return $this->render("template.html.twig");
    }
}
