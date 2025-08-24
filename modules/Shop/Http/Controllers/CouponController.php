<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Controllers;

use Catch\Base\CatchController as Controller;
use Catch\Exceptions\FailedException;
use Illuminate\Http\Request;
use Modules\Shop\Http\Requests\CouponRequest;
use Modules\Shop\Models\Coupon;
use Modules\Shop\Models\Pivots\UserHasCoupons;

class CouponController extends Controller
{
    public function __construct(
        protected readonly Coupon $model
    ) {
    }

    public function index(): mixed
    {
        return $this->model->setBeforeGetList(function ($query) {
            return $query->withCount('users');
        })->getList();
    }

    /**
     * @return mixed
     */
    public function store(CouponRequest $request)
    {
        return $this->model->storeBy($request->all());
    }

    /**
     * @return mixed
     */
    public function show($id)
    {
        return $this->model->withCount('users')->find($id);
    }

    /**
     * @return mixed
     */
    public function update($id, CouponRequest $request)
    {
        return $this->model->updateBy($id, $request->all());
    }

    /**
     * @return mixed
     */
    public function destroy($id): mixed
    {
        if ($this->model->has('users')->exists()) {
            throw new FailedException('该优惠券已被用户领取，无法删除');
        }

        return $this->model->deleteBy($id);
    }

    public function enable($id)
    {
        return $this->model->toggleBy($id);
    }

    /**
     * @return bool
     */
    public function give($id, Request $request)
    {
        return $this->model->giveUsers((int) $id, $request->get('users'));
    }

    /**
     * @return mixed
     */
    public function records(UserHasCoupons $userHasCoupons, Request $request)
    {
        return $userHasCoupons->getList($request->all());
    }
}
