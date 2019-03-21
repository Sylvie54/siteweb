<?php
namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use App\Form\PropertyType;

class AdminPropertyController extends AbstractController {

    /**
     * @var PropertyRepository
     */
    private $repository;

    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
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
     * @route("\admin{id}", name="admin.property.edit")
     * 
     */
    public function edit(Property $property)
    {
        // pour utiliser le formulaire dans le controller
        $form = $this->createForm(PropertyType::class, $property);
        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' =>$form->createView()
        ]);
    } 
}


