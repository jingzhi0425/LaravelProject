<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\BaseController;
use App\Models\ProductCategory;
use App\Http\Requests\ApiRequests\StoreProductCategoryRequest;
use App\Http\Requests\ApiRequests\UpdateProductCategoryRequest;
use App\Http\Requests\ApiRequests\ActiveProductCategoryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductCategoryApiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = ProductCategory::get();
        $category->makeHidden(['id']);

        return parent::resFormat(901, null, $category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductCategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            do {
                $request['uid'] = uniqid('UID');
                $uid_data = ProductCategory::where(['uid' => $request['uid']])->first();
            } while (!empty($uid_data));

            ProductCategory::create($request->all());

            DB::commit();
            return parent::resFormat(902);
        } catch (Exception $e) {
            DB::rollback();
            Log::channel("api")->error("StoreProductCategory Function Error(Admin/ProductCategoryApiController)", ["request" => $request->validated(), 'error' => $e->getMessage()]);
            return parent::resFormat(-1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show_product_category($uid)
    {
        $productCategory = ProductCategory::where(['uid' => $uid])->first();
        $productCategory->makeHidden(['id']);
        return parent::resFormat(903, null, $productCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductCategoryRequest  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update_product_category(UpdateProductCategoryRequest $request, $uid)
    {
        DB::beginTransaction();
        try {
            $productCategory = ProductCategory::where(['uid' => $uid])->first();
            $productCategory->update($request->all());
            DB::commit();
            return parent::resFormat(904);
        } catch (Exception $e) {
            DB::rollback();
            Log::channel("api")->error("UpdateProductCategory Function Error(Admin/ProductCategoryApiController)", ["request" => $request->validated(), 'error' => $e->getMessage()]);
            return parent::resFormat(-1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function delete_product_category($uid)
    {
        DB::beginTransaction();
        try {
            ProductCategory::where(['uid' => $uid])->delete();
            DB::commit();
            return parent::resFormat(905);
        } catch (Exception $e) {
            DB::rollback();
            Log::channel("api")->error("DeleteProductCategory Function Error(Admin/ProductCategoryApiController)", ["request" => $request->validated(), 'error' => $e->getMessage()]);
            return parent::resFormat(-1);
        }
    }

    public function active_product_category(ActiveProductCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $product_category = ProductCategory::whereIn('uid', request('uids'))->get();
            foreach ($product_category as $category) {
                $data = ['is_active' => 1];

                if ($category->is_active) {
                    $data = ['is_active' => 0];
                }

                $category->update($data);
            }
            DB::commit();
            return parent::resFormat(906);
        } catch (Exception $e) {
            DB::rollback();
            Log::channel("api")->error("ActiveProductCategory Function Error(Admin/ProductCategoryApiController)", ["request" => $request->validated(), 'error' => $e->getMessage()]);
            return parent::resFormat(-1);
        }
    }
}
