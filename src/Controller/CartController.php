<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use SessionIdInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session, ProductRepository $productRepersitory) {
        $panier = $session->get('panier', []);

        $panierwithData = [];
        foreach ($panier as $id => $quantity) {
            $panierwithData[] = [
                'product' => $productRepersitory->find($id),
                'quantity'  => $quantity,
            ];
            $total = 0;
            foreach ($panierwithData as $item) {
                $totalItem = $item['product']->getPrice() * $item['quantity'];
                $total += $totalItem;
            }
        }
        return $this->render('cart/index.html.twig', [
            'items' => $panierwithData,
            'total' => $total,
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     *
     */
    public function add($id, SessionInterface $session)
    { 
        $product = new Product;
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } 
        
        else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
         
    }


    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     *
     */
    public function remove($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
    }
}