<?php

namespace App\Controller\Api\Ozon;

use App\Service\Ozon\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/ozon/product/download", name="api_ozon_product_download")
     * @param ProductService $productService
     * @return JsonResponse
     */
    public function download(ProductService $productService): JsonResponse
    {

        $products = $productService->downloadProductList();

        return new JsonResponse(json_encode($products), 200, [], true);
    }
}
