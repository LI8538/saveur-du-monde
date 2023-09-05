<?php
namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{
    private RequestStack $requestStack;

    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;

    }

    public function addToCart(int $id): void{

        $cart = $this->requestStack->getSession()->get('cart',[]);
        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id]= 1;
        }
        $this->getSession()->set('cart', $cart);
    }




    
    public function removeToCard(int $id)
    {
        $cart = $this->requestStack->getSession()->get('cart',[]);
        unset($cart[$id]);
        return $this->getSession()->set('cart', $cart);
    }







    public function removeCartAll()
    {
        return $this->getSession()->remove('cart');
    }


    public function getTotal(): array
    {
        $cart = $this->getSession()->get('cart');
        $cartData = [];
        if($cart){
        foreach($cart as $id =>$quantity){
            $product =$this->em->getRepository(Product::class)->findOneBy(['id' => $id]);
            if (!$product) {
                
            }
            // $cartData = [];
            $cartData[] =[
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }
        return $cartData;
    }



    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}