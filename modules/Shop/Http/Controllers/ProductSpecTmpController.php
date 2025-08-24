<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Modules\Shop\Services\ProductSpecTmpService;

class ProductSpecTmpController extends Controller
{
    public function __construct(
        protected readonly ProductSpecTmpService $service
    ) {
    }

    public function index(): mixed
    {
        return $this->service->getList();
    }

    /**
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->service->store($request->all());
    }

    /**
     * @return mixed
     */
    public function show($id)
    {
        return $this->service->first($id);
    }

    /**
     * @return mixed
     */
    public function update($id, Request $request)
    {
        return $this->service->update($id, $request->all());
    }

    /**
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
