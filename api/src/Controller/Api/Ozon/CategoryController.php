<?php

namespace App\Controller\Api\Ozon;

use App\Entity\Catalog\Category;
use App\Service\Ozon\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/api/ozon/category/download", name="api_ozon_category_download")
     * @param CategoryService $categoryService
     * @return JsonResponse
     */
    public function download(CategoryService $categoryService): JsonResponse
    {

        $counter = $categoryService
            ->downloadCategories()
            ->saveCategories();

        return new JsonResponse(json_encode($counter), 200, [], true);
    }

    /**
     * @Route("/api/category/tree", name="getCategoryTree")
     * @param CategoryService $categoryService
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function getCategoryTree(CategoryService $categoryService, SerializerInterface $serializer)
    {
        $data = $categoryService->getCategoryTree();
        $data = $serializer->serialize($data, 'json', [
            'circular_reference_handler' => function (Category $object) {
                return $object->getId();
            }
        ]);
//        return $this->render('milalika_parser/index.html.twig', [
//        ]);
        return new JsonResponse($data, 200, [], true);
    }

}
