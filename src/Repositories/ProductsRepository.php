<?php

namespace Pdfsystems\OrderTrackSdk\Repositories;

use GuzzleHttp\Exception\GuzzleException;
use Pdfsystems\OrderTrackSdk\Dtos\Pagination\ProductList;
use Pdfsystems\OrderTrackSdk\Dtos\Product;
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
    public function search(int $perPage = 15, int $page = 1, array $params = []): ProductList
    {
        return $this->client->getDto('api/products', ProductList::class, array_merge($params, [
                'count' => $perPage,
                'page' => $page,
            ]));
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
     * @param Product $product
     * @param string $postalCode
     * @param int $quantity
     * @return array
     * @throws GuzzleException
     */
    public function calculateShipping(Product $product, string $postalCode, int $quantity = 1): array
    {
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
}
