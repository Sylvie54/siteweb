<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyController extends AbstractController
 {
     
   /* private $twig;
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    } */
        private $repository;
        private $em;

      public function __construct(PropertyRepository $repository, ObjectManager $em)
      //  public function __construct(PropertyRepository $repository)
        {
            $this->repository = $repository;
            $this->em = $em;
        }


    /**
     * @route("/biens", name="property.index")
     * @return Response
     */

    public function index() : Response
    {
<<<<<<< HEAD
        // creation d'un enregistrement
       /* $property = new Property();
        $property->setTitle('un petit studio')
        ->setPrice(80000)
        ->setRooms(1)
        ->setBedrooms(0)
        ->setDescription('agréable et calme')
        ->setSurface(20)
        ->setFloor(2)
        ->setHeat(1)
        ->setCity('Nancy')
        ->setAddress('15 boulevard Petain')
        ->setPostalCode('54000');
=======
       
     // creation d'un enregistrement
        $property = new Property();
        $property->setTitle('mon autre bien')
        ->setPrice(100000)
        ->setRooms(1)
        ->setBedrooms(30)
        ->setDescription('studio')
        ->setSurface(20)
        ->setFloor(3)
        ->setHeat(1)
        ->setCity('Montpellier')
        ->setAddress('15 boulevard Gambetta')
        ->setPostalCode('34000');
>>>>>>> 406f6d3229fb94f020f2d91f8031daf3bb5d6fa0
        $em =  $this->getDoctrine()->getManager();   
        $em->persist($property);
        $em->flush(); 

      /*  $repository = $this->getDoctrine()->getRepository(Property::class);
        dump($repository); */

        // récupération du premierenregistrement de la table
        // $property = $this->repository->find(1);

        // tous les enregistrements
        //  $property = $this->repository->findAll();
      
        // on passe un tableau de critères
        //$property = $this->repository->findOneBy(['floor' => 4]);

        // on utilise la fonction que l'on a crée dans le PropertyRepository permettant de voir les biens encore visibles
     /*   $property = $this->repository->findAllVisible();
        $property[0]->setSold(true);
        $this->em->flush();    
       // dump($property); */


        return $this->render('property/index.html.twig', [
           'current_menu' => 'properties'
           ]);
     /*  return new Response($this->twig->render('property/index.html.twig', [
           'current_menu' => 'properties'
       ])); */
    }
    /**
     * @return Response
     * @param Property property
     * @route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */

<<<<<<< HEAD

   // public function show($slug , $id): Response
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug)
        {
           return $this->redirectToRoute('property.show', [
              'id' => $property->getId(),
              'slug' => $property->getSlug()
            ], 301);
        }

    //  $property = $this->repository->find($id);
      return $this->render('property/show.html.twig', [
        'property' => $property,
        'current_menu' => 'properties'
        ]);
    }
}
=======
}
>>>>>>> 406f6d3229fb94f020f2d91f8031daf3bb5d6fa0
