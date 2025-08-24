<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Modules\Shop\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {
    }

    public function index(): mixed
    {
        return $this->productService->getList();
    }

    /**
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->productService->store($request->all());
    }

    /**
     * @return mixed
     */
    public function show($id)
    {
        return $this->productService->show($id);
    }

    /**
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return $this->productService->update($id, $request->all());
    }

    /**
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->productService->destroy($id);
    }

    public function enable($id, Request $request)
    {
        return $this->productService->enable($id, $request->get('field'));
    }

    /**
     * 批量上架
     * @param $id
     * @return bool
     */
    public function shelf($id)
    {
        return $this->productService->shelf($id);
    }

    /**
     * 批量下架
     *
     * @param $id
     * @return bool
     */
    public function unshelf($id)
    {
        return $this->productService->unshelf($id);
    }

    public function delist($id)
    {
        return $this->productService->delist($id);
    }
}
