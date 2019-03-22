<?php
namespace App\Controller\Admin;

// composants response et request 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
// utiliser les annotations pour les routes
use Symfony\Component\Routing\Annotation\Route;
// classe  mère "controller"
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// utiliser l'envirronement twig
use Twig\Environment;
// utiliser le patron de conception Repository contenant les requêtes de la classe Property
use App\Repository\PropertyRepository;
// appel de la classe Property
use App\Entity\Property;
// utiliser le formulaire auto_construit de la classe Property avec la console
// make:form nomform (doit toujours finir par Type ex: propertyType)
use App\Form\PropertyType;
// utilisation ObjectManager pour la persistance des données
use Doctrine\Common\Persistence\ObjectManager;

// la lcasse hérite de la classe mère AbstractController pouvant utiliser Response et Request 
class AdminPropertyController extends AbstractController {

    // attribut faisant le lien entre la classe et les requêtes
    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    // constructeur le l'objet controller
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    // affichage de la page index avec tous les biens et accès à la page twig "index" de Admin
    // route "web" : /admin , nom du template : admin/property/index.html.twig 
    /**
     * @route("/admin", name="admin.property.index")
     * @return \Symfony\component\HttpFoudation\Response
     */

    public function index()
    {
     //  méthode héritée de la classe ServiceEntityRepository :
     // 4 méthodes disponibles avec leurs paramètres
     // renvoie un tableau des properties (objets de la classe Property)
        $properties = $this->repository->findall();
        // envoi dans le template index d'admin un tableau de properties (methode compact)
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    // page de création d'un bien. Paramètre : l'objet request pour récupérer les données du formulaire 
    // route web : /admin/property/create, nom du template : admin/property/new.html.twig
    /**
     * @route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        // on instancie un nouveau objet Property 
        $property = new property();
        // on crée le formulaire PropertyType qui recevra l'objet $property de la classeProperty
        $form = $this->createForm(PropertyType::class, $property);
        // on récupèr les données du formulaire depuis l'objet request
        $form->handleRequest($request);
        // si le formulaire est valide, on enregisrte et on redirige vers la page index de l'admin
        // persist : mise en cache des données à enregistrer, flush = commit
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();

            // on redirige vers la page admin/index
            return $this->redirectToRoute('admin.property.index');
        }
        // sinon, on envoie la page admin/property/new avec en paramètre l'objet property vide et
        // on passe la méthode createView() du formulaire à la vue
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }

    // Edition: la page précedante a passé l'objet Property $property en paramètre
    // la route aura l'id de la property affiché après /property/admin
    /**
     * @route("/property/admin{id}", name="admin.property.edit", methods="GET|POST")
     * 
     */
    public function edit(Property $property, Request $request)
    {
        // pour utiliser le formulaire dans le controller
        // on passe l'objet property en paramètre au formulaire
        $form = $this->createForm(PropertyType::class, $property);
        
        // fait le lien entre les variables saisies et l'objet : met les valeurs saisies dans le formalaire $form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }
    /**
     * @route("/property/admin{id}", name="admin.property.delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request) {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
        {
        $this->em->remove($property);
        $this->em->flush();
        // pour les tests
        //return new Response('Suppression');
        }
        return $this->redirectToRoute('admin.property.index');
        }

    }    



