<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Product::with(['product_category'])->select(sprintf('%s.*', (new Product())->table))->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'product_show';
                $editGate = 'product_edit';
                $deleteGate = 'product_delete';
                $crudRoutePart = 'product';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('uid', function ($row) {
                return $row->uid ? $row->uid : '';
            });
            $table->editColumn('bar_code_id', function ($row) {
                return $row->bar_code_id ? $row->bar_code_id : '';
            });
            $table->editColumn('product_category', function ($row) {
                return $row->product_category ? $row->product_category->name : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('status', function ($row) {
                return Product::STATUS_SELECT[$row->status] ? Product::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'product_category']);

            return $table->make(true);
        }

        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_categorys = ProductCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $images = Image::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.product.create', compact('product_categorys', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $baseController = new BaseController();

        do {
            $request['uid'] = $baseController->generateUID('product', 4);

            $uid_data = Product::where([
                'uid' => $request['uid'],
            ])->first();
        } while (!empty($uid_data));

        Product::create($request->all());
        return redirect()->route('admin.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load('product_category', 'images');
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product_categorys = ProductCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');;
        $images = Image::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');;

        $product->load('images', 'product_category');

        return view('admin.product.edit', compact('product', 'images', 'product_categorys'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index');
    }

    public function massDestroy(Request $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return redirect()->route('admin.product.index');
    }
}
