<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('form/form.html.twig', [
            'products' => $products,
        ]);
    }
    // product/index.html.twig


    /**
     * @Route("/products/new", name="product_new", methods={"GET","POST"})
     * @Route("/products/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ?Product $product = null): Response
    {
        if (!$product) {
            $product = new Product();
        }

        $form = $this->createForm(ProductType::class, $product)
                     ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/productswhitcat/new", name="productwithCat_new", methods={"GET","POST"})
     */
    public function newproduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductWihtCatType::class, $product)
                     ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/productwithCat.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}

