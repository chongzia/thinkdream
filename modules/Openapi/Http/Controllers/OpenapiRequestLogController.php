<?php
declare(strict_types=1);

namespace Modules\Openapi\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Modules\Openapi\Models\OpenapiRequestLog;
use Illuminate\Http\Request;


class OpenapiRequestLogController extends Controller
{
    public function __construct(
        protected readonly OpenapiRequestLog $model
    ){}

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->model->deleteBy($id);
    }
}
