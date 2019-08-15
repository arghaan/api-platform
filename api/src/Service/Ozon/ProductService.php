<?php


namespace App\Service\Ozon;


use App\Entity\Catalog\Product;
use App\Repository\ProductRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class ProductService
 * @package App\Service\Ozon
 */
final class ProductService
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
    private $productCounter = 0;

    /**
     * @var array
     */
    private $products = [];

    private $productRepository;

    /**
     * @param EntityManagerInterface $em
     * @param HttpClientInterface $httpClient
     * @param ProductRepository $repository
     */
    public function __construct(EntityManagerInterface $em, HttpClientInterface $httpClient, ProductRepository $repository)
    {
        $this->em = $em;
        $this->httpClient = $httpClient;
        $this->productRepository = $repository;
    }

    /**
     * @return ProductService
     */
    public function downloadProductList()
    {
        try {
            $response = $this->httpClient->request('POST', $_ENV['OZON_URL'].'/v1/product/list', [
                'headers' => [
                    'Client-Id' => $_ENV['CLIENT_ID'],
                    'Api-Key' => $_ENV['API_KEY'],
                ],
                'json' => ['page_size' => '1000'],
            ]);
        } catch (TransportExceptionInterface $e) {
            dump($e->getMessage());
        }
        if (isset($response)) {
            try {
                $this->products = $response->toArray()['result'];
                $this->saveProducts();
            } catch (
            ClientExceptionInterface |
            RedirectionExceptionInterface |
            ServerExceptionInterface |
            TransportExceptionInterface |
            DecodingExceptionInterface $e
            ) {
                dump($e->getMessage());
            }
        }
        return $this;
    }

    public function saveProducts(): void
    {
        $cmd = $this->em->getClassMetadata(Product::class);
        $connection = $this->em->getConnection();
        $connection->beginTransaction();

        try {
            $connection->query("DELETE FROM {$cmd->getTableName()}");
            $connection->query("ALTER TABLE {$cmd->getTableName()} AUTO_INCREMENT = 1");
            $connection->commit();
        } catch (DBALException $e) {
        }

        foreach ($this->products as $arrProduct) {
            $product = new Product();
            $product->setOzonId($arrProduct['product_id']);
            $product->setOfferId($arrProduct['offer_id']);
            $this->em->persist($product);
        }
        $this->em->flush();
    }
}
