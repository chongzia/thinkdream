<?php

declare(strict_types=1);

namespace Modules\Ai\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Modules\Ai\Models\ModelSessionMessages;

/**
 * @class AiModelSessionMessagesController
 */
class ModelSessionMessagesController extends Controller
{
    public function __construct(
        protected readonly ModelSessionMessages $model,
    ) {}

    /**
     * 列表
     */
    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     * 删除数据
     */
    public function destroy(mixed $id): mixed
    {
        return $this->model->deleteBy($id);
    }
}
