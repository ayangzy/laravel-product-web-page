<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Fetch the created products from xml and display to view
     */
    public function index()
    {
        $products = $this->productService->fetchProducts();

        $totalValueSum = $this->calculateTotalValueSum($products);

        return view('products.index', compact('products', 'totalValueSum'));
    }

    /**
     * Load products data from xml and display to view real time when an product is created or updated
     */
    public function productData()
    {
        $products = $this->productService->fetchProducts();

        $totalValueSum = $this->calculateTotalValueSum($products);

        return view('products._product-data', compact('products', 'totalValueSum'));
    }

    /**
     * Return store product response
     * 
     * @param \App\Http\Requests\CreateProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateProductRequest $request)
    {
        $product = $this->productService->storeProduct($request);

        return $this->successResponse('Product created successfully', $product);
    }


    /**
     * Return update product response
     * 
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->updateProduct($request, $id);

        return $this->successResponse('Product updated successfully', $product);
    }


    /**
     * Calculate the sum total value
     * 
     * @param mixed $products
     * @return mixed
     */
    private function calculateTotalValueSum($products)
    {
        $totalValueSum = 0;

        foreach ($products as $product) {
            $totalValueSum += $product->total_value;
        }

        return $totalValueSum;
    }
}