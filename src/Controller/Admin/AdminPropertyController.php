<?php
namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use App\Form\PropertyType;
use Doctrine\Common\Persistence\ObjectManager;

class AdminPropertyController extends AbstractController {

    /**
     * @var PropertyRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @route("/admin", name="admin.property.index")
     * @return \Symfony\component\HttpFoudation\Response
     */

    public function index()
    {
        $properties = $this->repository->findall();
        // envoi dans le template indec d'admin d'un tableau de properties (methode compact)
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @route("/admin/property/create", name="admin.property.new")
     */
    public function new(Request $request)
    {
        $property = new property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    }


    /**
     * @route("/property/admin{id}", name="admin.property.edit", methods="GET|POST")
     * 
     */
    public function edit(Property $property, Request $request)
    {
        // pour utiliser le formulaire dans le controller
        $form = $this->createForm(PropertyType::class, $property);
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



