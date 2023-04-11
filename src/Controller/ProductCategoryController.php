<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Form\ProductCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductCategoryController extends AbstractController
{
    private $productCategories = [];

    /**
     * @Route("/product-category/new", name="product_category_new")
     */
    public function new(Request $request)
    {
        $productCategory = new ProductCategory();
        $form = $this->createForm(ProductCategoryType::class, $productCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->productCategories[] = $productCategory;

            return $this->redirectToRoute('product_category_list');
        }

        return $this->render('product_category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
