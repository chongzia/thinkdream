<?php

declare(strict_types=1);

namespace Modules\Snmp\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Modules\Snmp\Excel\Export\SnmpUsersExport;
use Modules\Snmp\Excel\Import\SnmpUsersImport;
use Modules\Snmp\Http\Requests\SnmpUsersRequest;
use Modules\Snmp\Models\SnmpUsers;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @class SnmpUsersController
 */
class SnmpUsersController extends Controller
{
    /**
     * @param  SnmpUsers  $model
     */
    public function __construct(
        protected readonly SnmpUsers $model,
    ) {}

    /**
     * 列表
     *
     * @return mixed
     */
    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     * 保存数据
     *
     * @param  SnmpUsersRequest  $request
     * @return mixed
     */
    public function store(SnmpUsersRequest $request): mixed
    {
        return $this->model->storeBy($request->all());
    }

    /**
     * 展示数据
     *
     * @param  mixed  $id
     * @return Model|null
     */
    public function show(mixed $id): ?Model
    {
        return $this->model->firstBy($id, columns: $this->model->getForm());
    }

    /**
     * 更新数据
     *
     * @param  mixed  $id
     * @param  SnmpUsersRequest  $request
     * @return mixed
     */
    public function update(mixed $id, SnmpUsersRequest $request): mixed
    {
        return $this->model->updateBy($id, $request->all());
    }

    /**
     * 删除数据
     *
     * @param  mixed  $id
     * @return bool|null
     */
    public function destroy(mixed $id): ?bool
    {
        return $this->model->deleteBy($id);
    }

    /**
     * 导出
     *
     * @param  Request  $request
     * @param  SnmpUsersExport  $export
     * @return BinaryFileResponse
     */
    public function export(Request $request, SnmpUsersExport $export): BinaryFileResponse
    {
        // 导出
        return $export->download();
    }

    /**
     * 导入
     *
     * @param  Request  $request
     * @param  SnmpUsersImport  $import
     * @return SnmpUsersImport|array|int
     */
    public function import(Request $request, SnmpUsersImport $import): SnmpUsersImport|array|int
    {
        // 导入
        return $import->import($request->file('file'));
    }
}
