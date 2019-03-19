<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use App\Repository\PropertyRepository;


class HomeController extends AbstractController {
    /**
     * @var twig\Environment
     */

<<<<<<< HEAD
       private $twig;
=======
    //   private $twig;
>>>>>>> c0a9977fb10eeeb7633759c5d4b26e606d81980c
  /*  public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    } */
   

    /**
     * @route("/", name="home")
     * @param PropertyRepository $repository
     * @return Response
     */
    public function index(PropertyRepository $repository): Response

    {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
     //   return new Response($this->twig->render('pages/home.html.twig'));
    }
}