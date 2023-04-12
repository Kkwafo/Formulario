<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use App\Form\ProductCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductCategoryController extends AbstractController
{
    /**
     * @Route("/product-category/new", name="product_category_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager, ?ProductCategory $productCategory = null): Response
    {
        if (!$productCategory) {
            $productCategory = new ProductCategory();
        }

        $form = $this->createForm(ProductCategoryType::class, $productCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product_category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/products-categories/list", name="product_category_list", methods={"GET"})
     */
    public function listCategories(ProductCategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('product/categoryList.html.twig', [
            'categories' => $categories,
        ]);
    }
}
