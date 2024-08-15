<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use JetBrains\PhpStorm\ArrayShape;
use Pdfsystems\OrderTrackSdk\Dtos\Inventory;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\ProductList;
use Pdfsystems\OrderTrackSdk\Dtos\Product;
use Pdfsystems\OrderTrackSdk\Dtos\PurchaseOrder;
use Pdfsystems\OrderTrackSdk\Exceptions\NotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductsRepository extends Repository
{
    /**
     * Searches all products for a given distributor
     *
     * @param int $perPage
     * @param int $page
     * @param array $params
     * @return ProductList
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function search(
        int $perPage = 15,
        int $page = 1,
        #[ArrayShape(['item_number' => 'string', 'style_name' => 'string', 'color_name' => 'string', 'discontinued' => 'bool'])]
        array $params = []
    ): ProductList {
        return $this->client->getDto('api/products', ProductList::class, array_merge($params, [
                'count' => $perPage,
                'page' => $page,
            ]));
    }

    /**
     * Loads a product by its primary key
     *
     * @param int $id
     * @return Product
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function find(int $id): Product
    {
        return $this->client->getDto("api/products/$id", Product::class);
    }

    /**
     * Loads a distributor's product by its item number
     *
     * @param string $itemNumber
     * @param int|null $teamId
     * @return Product
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function findByItemNumber(string $itemNumber, int $teamId = null): Product
    {
        $results = $this->search(1, 1, [
            'item_number' => $itemNumber,
            'team_id' => $teamId,
        ]);

        if ($results->total > 0) {
            return $results->data[0];
        } else {
            throw new NotFoundException("Product with item number $itemNumber not found");
        }
    }

    /**
     * Calculates shipping charges for a given product
     *
     * @param Product|int $product
     * @param string $postalCode
     * @param int $quantity
     * @return array
     * @throws GuzzleException
     * @throws UnknownProperties
     */
    public function calculateShipping(Product|int $product, string $postalCode, int $quantity = 1): array
    {
        if (is_int($product)) {
            $product = $this->find($product);
        }

        $response = [];
        $otResponse = $this->client->getJson('/api/products/' . $product->id . '/shipping', [
            'quantity' => $quantity,
            'postal_code' => $postalCode,
        ]);

        foreach($otResponse as $rate) {
            $response[$rate['serviceName']] = $rate['rate'];
        }

        return $response;
    }

    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function getInventory(Product|int $product): array
    {
        if ($product instanceof Product) {
            $product = $product->id;
        }

        return $this->client->getDtoArray("/api/products/$product/inventory", Inventory::class);
    }

    /**
     * @throws UnknownProperties
     * @throws GuzzleException
     */
    public function getPurchaseOrders(Product|int $product): array
    {
        if ($product instanceof Product) {
            $product = $product->id;
        }

        return $this->client->getDtoArray("/api/products/$product/purchase-orders", PurchaseOrder::class);
    }
}
