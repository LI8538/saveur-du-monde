<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    // #[Route('/all', name: 'app_product_All', methods: ['GET'])]
    // public function all(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    // {
    //     // return $this->render('product/index.html.twig', [
    //     //     'products' => $productRepository->findAll(),
    //     // ]);
    //     $data = $productRepository->findAll();

    //     $pagination = $paginator->paginate(
    //     $data, // Requête contenant les données à paginer
        
    //     $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
    //     12 // Nombre de résultats par page
    // );
    //     return $this->render('chine/index.html.twig', [
    //         'products' => $pagination
    //     ]);
    // }















    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $product = new Product();
    //     $form = $this->createForm(ProductType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($product);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('product/new.html.twig', [
    //         'product' => $product,
    //         'form' => $form,
    //     ]);
    

     // SluggerInterface $slugger pour les affichage d'image
     public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
     {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
 
 // affichage d'image start

             $image = $form->get('image')->getData();
 
             // Si une image a été uploadée
             if ($image) {
 
                 // 2 - Modifier le nom de l'image (nom unique)
                 $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
 
                 // Transforme le nom de l'image en slug pour l'URL (minuscule, sans accent, sans espace, etc.)
                 $safeFilename = $slugger->slug($originalFilename);
 
                 // Reconstruit le nom de l'image avec un identifiant unique et son extension
                 $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
 
                 // 3 - Enregistrer l'image dans son répertoire ('articles_images')
                 try {
                     $image->move(
                         $this->getParameter('products_img'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                     
                 }
 
                 // 4 - Ajouter le nom de l'image à l'objet en cours (setImage)
                 $product->setImage($newFilename);
             }
 // affichage d'image end
 
             $entityManager->persist($product);
             $entityManager->flush();
 
             return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
         }
 
         return $this->render('product/new.html.twig', [
            'product' => $product,
             'form' => $form,
         ]);

    }






    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
