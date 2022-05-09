<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Entity\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $products = Product::query()
            ->with('config')
            ->limit(100)
            ->get()
            ->toArray();

        return response()->json($products);
    }

    /**
     * @param int $productId
     *
     * @return JsonResponse
     */
    public function getById(int $productId): JsonResponse
    {
        $product = Product::query()
            ->with('config')
            ->where(['id' => $productId])
            ->first()
            ?->toArray();

        return response()->json(
            $product,
            $product === null ? Response::HTTP_NOT_FOUND : Response::HTTP_OK
        );
    }
}
