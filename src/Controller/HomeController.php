<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
// utiliser le patron de conception Repository contenant les requêtes de la classe Property
use App\Repository\PropertyRepository;


class HomeController extends AbstractController {
    
    /**
     * @route("/", name="home")
     * @param PropertyRepository $repository
     */
    public function index(PropertyRepository $repository)

    {
        // trouve les biens non vendus (PropertyRepository.php) (sold = 0) et envoie la page home
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'properties' => $properties
        ]);
    }
}