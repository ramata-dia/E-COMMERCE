<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Form\SearchProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private $repository;
    public function __construct(
        ProductRepository $repository,
        EntityManagerInterface $manager
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
    }
    /**
     * @Route("/product", name="product")
     */
    public function index( Request $request): Response
    { 
        

         $form = $this->createForm(SearchProductType::class);
         $products = $this->repository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form'=> $form->createView(),
        ]);

    }

     /**
     * @Route("/product/categorie", name="product_categorie")
     */
    public function createCategorie(Request $request , EntityManagerInterface $manager): Response
    {
            $categorie = new Categories();
             $form = $this->createForm(CategoriesType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //recuperation de l'image depuis le formulaire
            
            $manager->persist($categorie);
            $manager->flush();
            
        }
        return $this->render('product/categorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    
    /**
     * @Route("/product/new", name="product_new")
     */
    public function new(Request $request,EntityManagerInterface $manager): Response
     {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //recuperation de l'image depuis le formulaire

            $image = $form->get('image')->getData();
            if ($image) {
                //creation d'un nom pour l'image l'execution recupere

                $imageName = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('image_directory'),
                    $imageName
                );

                //on enregistre le nom de l'image dans la base de donnee
                $product->setImage($imageName);
            }

            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('product_new');
        }
        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}