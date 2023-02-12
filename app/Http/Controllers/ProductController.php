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


    public function store(CreateProductRequest $request)
    {
        $product = $this->productService->storeProduct($request);

        return $this->successResponse('Product created successfully', $product);
    }


    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->updateProduct($request, $id);

        return $this->successResponse('Product updated successfully', $product);
    }
}