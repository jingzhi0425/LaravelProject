<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use Gate;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProductCategory::query()->select(sprintf('%s.*', (new ProductCategory())->table))->orderBy('created_at', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'product_category_show';
                $editGate = 'product_category_edit';
                $activeGate = 'product_category_edit';
                $inactiveGate = 'product_category_edit';
                $deleteGate = 'product_category_delete';
                $crudRoutePart = 'product-category';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'activeGate',
                    'inactiveGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('uid', function ($row) {
                return $row->uid ? $row->uid : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('is_active', function ($row) {
                return ProductCategory::STATUS_SELECT[$row->is_active] ? ProductCategory::STATUS_SELECT[$row->is_active] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.ProductCategory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ProductCategory.create');
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
            return redirect()->route('admin.product-category.index');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('admin.product-category.create')->withInput($request->input())->withErrors(['error' => ['Something Error !']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        return view('admin.ProductCategory.show', compact('productCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('admin.ProductCategory.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductCategoryRequest  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        try {
            DB::beginTransaction();

            $productCategory->update($request->all());

            DB::commit();
            return redirect()->route('admin.product-category.index');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('admin.product-category.edit', $productCategory->id)->withInput($request->input())->withErrors(['error' => ['Something Error !']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return redirect()->route('admin.product-category.index');
    }

    public function massDestroy(Request $request)
    {
        ProductCategory::whereIn('id', request('ids'))->delete();

        return redirect()->route('admin.product-category.index');
    }

    public function active(Request $request)
    {
        ProductCategory::where('id', $request->id)->update(['is_active' => 1]);
        return redirect()->route('admin.product-category.index');
    }

    public function inactive(Request $request)
    {
        ProductCategory::where('id', $request->id)->update(['is_active' => 0]);
        return redirect()->route('admin.product-category.index');
    }
}
