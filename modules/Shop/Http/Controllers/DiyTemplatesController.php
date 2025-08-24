<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Modules\Shop\Models\Category;
use Modules\Shop\Models\DiyTemplates;
use Illuminate\Http\Request;

class DiyTemplatesController extends Controller
{
    public function __construct(
        protected readonly DiyTemplates $model
    ) {
    }

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->model->storeBy($request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->model->firstBy($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return $this->model->updateBy($id, $request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->model->deleteBy($id);
    }


    /**
     * 获取DIY商品
     *
     * @param Request $request
     * @param Category $category
     * @return mixed
     */
    public function getProducts(Request $request, Category $category)
    {
        return $category->getProductsBy($request->get('category_ids'), $request->get('limit'), $request->get('sort'));
    }
}
