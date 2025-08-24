<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Modules\Shop\Models\ProductBrand;

class ProductBrandController extends Controller
{
    public function __construct(
        protected readonly ProductBrand $model
    ) {
    }

    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->model->storeBy($request->all());
    }

    /**
     * @return mixed
     */
    public function show($id)
    {
        return $this->model->firstBy($id);
    }

    /**
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return $this->model->updateBy($id, $request->all());
    }

    /**
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->model->deleteBy($id);
    }
}
