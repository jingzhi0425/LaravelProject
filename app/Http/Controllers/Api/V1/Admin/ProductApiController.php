<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Http\Requests\ApiRequests\StoreProductRequest;
use App\Http\Requests\ApiRequests\UpdateProductRequest;
use App\Http\Requests\ApiRequests\ActiveProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ClientApiValidationException;

class ProductApiController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('product_category', 'images')->get();

        foreach ($products as $product) {
            $product->status = Product::STATUS_SELECT[$product->status];
            $product->product_category_name = $product->product_category->name;
            $product->images_url = $product->images->document->url;
        }

        $products->makeHidden(['media', 'images', 'product_category', 'id']);

        return parent::resFormat(951, null, ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            do {
                $request['uid'] = $this->generateUID('product', 4);

                $uid_data = Product::where([
                    'uid' => $request['uid'],
                ])->first();
            } while (!empty($uid_data));

            if (!$request['is_repeat']) {
                $repeat_name = Product::where(['name' => $request['name']])->count();

                if ($repeat_name != 0) {
                    return parent::resFormat(957, null, ['repeat_time' => $repeat_name]);
                }
            }

            Product::create($request->all());
            DB::commit();
            return parent::resFormat(952);
        } catch (Exception $e) {
            DB::rollback();
            Log::channel("api")->error("StoreProduct Function Error(Admin/ProductApiController)", ["request" => $request->validated(), 'error' => $e->getMessage()]);
            return parent::resFormat(-1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show_product($uid)
    {
        $product = Product::where(['uid' => $uid])->first();

        $product->status = Product::STATUS_SELECT[$product->status];
        $product->product_category_name = $product->product_category->name;
        $product->images_url = $product->images->document->url;

        $product->makeHidden(['media', 'images', 'product_category', 'id']);

        return parent::resFormat(953, null, ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update_product(UpdateProductRequest $request, $uid)
    {
        DB::beginTransaction();
        try {
            $product = Product::where(['uid' => $uid])->first();
            $validator = Validator::make($request->all(), [
                'bar_code_id' => ['string', 'required', 'unique:products,bar_code_id,' . $product->id],
            ]);

            if ($validator->fails()) {
                throw new ClientApiValidationException($validator);
            }

            if (!$request['is_repeat']) {
                $repeat_name = Product::where(['name' => $request['name']])->count();

                if ($repeat_name != 1) {
                    return parent::resFormat(957, null, ['repeat_time' => $repeat_name]);
                }
            }

            $product->update($request->all());
            return parent::resFormat(954);
        } catch (Exception $e) {
            DB::rollback();
            return parent::resFormat(-1);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete_product($uid)
    {
        Product::where(['uid' => $uid])->delete();
        return parent::resFormat(955);
    }

    public function active_product(ActiveProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $products = Product::whereIn('uid', request('uids'))->get();
            foreach ($products as $product) {
                $data = ['status' => 1];

                if ($product->status) {
                    $data = ['status' => 0];
                }

                $product->update($data);
            }
            DB::commit();
            return parent::resFormat(956);
        } catch (Exception $e) {
            DB::rollback();
            Log::channel("api")->error("ActiveProduct Function Error(Admin/ProductApiController)", ["request" => $request->validated(), 'error' => $e->getMessage()]);
            return parent::resFormat(-1);
        }
    }
}
