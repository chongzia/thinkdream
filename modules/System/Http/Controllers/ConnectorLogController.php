<?php

declare(strict_types=1);

namespace Modules\System\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Illuminate\Http\Request;
use Modules\System\Models\ConnectorLog;
use Modules\System\Models\SystemConfig;
use Modules\System\Support\Configure;

class ConnectorLogController extends Controller
{
    public function __construct(
        protected readonly ConnectorLog $model
    ) {
    }

    public function index(): mixed
    {
        return $this->model->getList();
    }

    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    public function config(Request $request, SystemConfig $config)
    {
        if ($request->isMethod('POST')) {
            return $config->storeBy(
                Configure::parse('connector', $request->all())
            );
        } else {
            return config('connector.'.$request->get('prefix'));
        }
    }

    /**
     * 聚合数据
     *
     * @return array
     */
    public function summary()
    {
        return $this->model->summary();
    }

    /**
     * 状态码
     *
     * @return array
     */
    public function statusCode(): array
    {
        return $this->model->statusCodes();
    }

    /**
     * 接口耗时
     *
     * @return array
     */
    public function timeTaken(): array
    {
        return $this->model->timeTaken();
    }

    /**
     *
     * 请求量 top10
     *
     * @return array
     */
    public function requestsTop10(): array
    {
        return $this->model->requestsTop10();
    }

    /**
     * 错误请求 top10
     *
     * @return array
     */
    public function requestErrorsTop10(): array
    {
        return $this->model->requestErrorsTop10();
    }

    /**
     * 最快请求 top10
     *
     * @return array
     */
    public function requestFastTop10(): array
    {
        return $this->model->requestFastTop10();
    }

    /**
     * 最慢请求 top10
     *
     * @return array
     */
    public function requestSlowTop10(): array
    {
        return $this->model->requestSlowTop10();
    }

    /**
     * 每小时请求
     *
     * @return array
     */
    public function everyHourRequests(): array
    {
        return $this->model->everyHourRequests();
    }

    /**
     *  每分钟请求
     *
     * @return array
     */
    public function everyMinuteRequests(): array
    {
        return $this->model->everyMinuteRequests();
    }
}
