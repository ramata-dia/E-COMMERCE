<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager=$manager;
    }

    /**
     * @Route("/admin/product", name="admin_product")
     * @return Response
     */
    public function index(): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(ProductType::class)
            ->findAll();
            return $this->redirectToRoute('admin_product');
        return $this->render('admin/product/index.html.twig', [
            
            'product' => $product,
        ]);
    }

    #[Route('/admin/edit/{id}', name: 'product_edit')]

    public function edit(Request $request, Product $product,EntityManager $manager) 
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Product Created! Knowledge is power!');
            return $this->redirectToRoute('product_edit');
            return $this->render('admin/admi_edit.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
    #[Route('/admin/delete/{slug}', name: 'admin_product_delete')]
    public function delete(Product $product, EntityManager $manager): Response
    {
        $this->manager = $manager;
        $this->manager->remove($product);
        $this->manager->flush();
        $this->addFlash('success', 'Produit supprimer avec success');
        return $this->redirectToRoute('admin_product');
        
    }
}
