<?php

namespace App\Service\Ozon;

use App\Entity\Catalog\Category;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\{
    ClientExceptionInterface,
    DecodingExceptionInterface,
    RedirectionExceptionInterface,
    ServerExceptionInterface,
    TransportExceptionInterface
};
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class CategoryService
 * @package App\Service\Ozon
 */
final class CategoryService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var int
     */
    private $categoryCounter = 0;

    /**
     * @var array
     */
    private $categories = [];

    private $categoryRepository;

    /**
     * @param EntityManagerInterface $em
     * @param HttpClientInterface $httpClient
     * @param CategoryRepository $repository
     */
    public function __construct(EntityManagerInterface $em, HttpClientInterface $httpClient, CategoryRepository $repository)
    {
        $this->em = $em;
        $this->httpClient = $httpClient;
        $this->categoryRepository = $repository;
    }

    /**
     * @return CategoryService
     */
    public function downloadCategories()
    {
        try {
            $response = $this->httpClient->request('POST', $_ENV['OZON_URL'].'/v1/category/tree', [
                'headers' => [
                    'Client-Id' => $_ENV['CLIENT_ID'],
                    'Api-Key' => $_ENV['API_KEY'],
                ],
                'json' => ['' => ''],
            ]);
        } catch (TransportExceptionInterface $e) {
        }
        if (isset($response)) {
            try {
                $this->categories = $response->toArray()['result'];
            } catch (ClientExceptionInterface $e) {
            } catch (DecodingExceptionInterface $e) {
            } catch (RedirectionExceptionInterface $e) {
            } catch (ServerExceptionInterface $e) {
            } catch (TransportExceptionInterface $e) {
            }
        }
        return $this;
    }

    /**
     * @return int
     */
    public function saveCategories(): int
    {
        $cmd = $this->em->getClassMetadata(Category::class);
        $connection = $this->em->getConnection();
        $connection->beginTransaction();

        try {
            $connection->query("DELETE FROM {$cmd->getTableName()}");
            $connection->query("ALTER TABLE {$cmd->getTableName()} AUTO_INCREMENT = 1");
            $connection->commit();
        } catch (DBALException $e) {
            dump($e->getMessage());
        }

//        $root = new Category();
//        $root->setCategoryId(0)
//            ->setTitle('root');
//        $this->em->persist($root);
        foreach ($this->categories as $category) {
            $currCategory = $this->createCategory([
                'category_id' => $category['category_id'],
                'title' => $category['title'],
                'parent' => null,
            ]);
            $this->recurse($category, $currCategory);
        }
        $this->em->flush();
        return $this->categoryCounter;
    }


    public function getCategoryTree(){
        return $this->categoryRepository->findBy(['parent' => null], ['title' => 'asc']);
    }

    // Private

    /**
     * @param array $currCategory
     * @param Category $parent
     */
    private function recurse(array $currCategory, Category $parent): void
    {
        foreach ($currCategory['children'] as $child) {
            $thisCategory = $this->createCategory([
                'category_id' => $child['category_id'],
                'title' => $child['title'],
                'parent' => $parent,
            ]);
            $this->recurse($child, $thisCategory);
        }
    }

    /**
     * @param array $arrCategory
     * @return Category
     */
    private function createCategory(array $arrCategory): Category
    {
        $category = new Category();
        $category->setCategoryId($arrCategory['category_id']);
        $category->setTitle($arrCategory['title']);
        if ($arrCategory['parent']) {
            $category->setParent($arrCategory['parent']);
        }

        $this->em->persist($category);
        $this->categoryCounter++;
        return $category;
    }

}
