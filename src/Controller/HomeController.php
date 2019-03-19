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

       private $twig;
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