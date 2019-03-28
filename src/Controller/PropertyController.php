<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use App\Entity\Property;
use App\Entity\Contact;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use  Knp\Component\Pager\PaginatorInterface;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Form\ContactType;
use App\Notification\ContactNotification;



class PropertyController extends AbstractController
 {
     
  
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

    public function index(PaginatorInterface $paginator, Request $request) : Response
    {

            
     // exemple de creation d'un enregistrement
      /* $property = new Property();
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
        $em =  $this->getDoctrine()->getManager();   
        $em->persist($property);
        $em->flush(); */

      /* 
      // affichage en Response de la property sélectionnée
      $repository = $this->getDoctrine()->getRepository(Property::class);
        dump($repository); */

        // récupération du premier enregistrement de la table
        // $property = $this->repository->find(1);

        // tous les enregistrements
        //  $property = $this->repository->findAll();
      
        // on passe un tableau de critères
        //$property = $this->repository->findOneBy(['floor' => 4]);

        // on utilise la fonction que l'on a crée dans le PropertyRepository permettant de voir les biens encore visibles
     /*   $property = $this->repository->findAllVisible();
     // on met le sold à true (bien vendu) et on mat à jour
        $property[0]->setSold(true);
        $this->em->flush();    
       // dump($property); */

       $search = new PropertySearch();
       $form = $this->createForm(PropertySearchType::class, $search);
       $form->handleRequest($request);

       $properties = $paginator->paginate(
         $this->repository->findAllVisibleQuery($search),
         $request->query->getInt('page', 1), 
          12
        );

        return $this->render('property/index.html.twig', [
           'current_menu' => 'properties',
           'properties' => $properties,
           'form' => $form->createView()
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


   // public function show($slug , $id): Response
    public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response
    {
      

        if ($property->getSlug() !== $slug)
        {
           return $this->redirectToRoute('property.show', [
              'id' => $property->getId(),
              'slug' => $property->getSlug()
              // redirection suite à un probleme : 301
            ], 301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
          // gestion de la notification avec la classe ContactNotification, méthode notify
          $notification->notify($contact);
          $this->addFlash('success', 'votre email a bien été envoyé');
           
          return $this->redirectToRoute('property.show', [
            'id' => $property->getId(),
            'slug' => $property->getSlug()
          ]); 
        }


    //  $property = $this->repository->find($id);
      return $this->render('property/show.html.twig', [
        'property' => $property,
        'current_menu' => 'properties',
        'form' => $form->createView()
        ]);
    }
}
