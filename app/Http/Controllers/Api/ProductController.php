<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderby = ($request->get('orderby') !== null) ? $request->get('orderby') : 'id';
        $order = ($request->get('order') !== null) ? $request->get('order') : 'ASC';

        $data = (Product::orderBy($orderby, $order)->paginate(50))->toArray()['data'];

        if (!$data) {
            return $this->sendError('Not found', 404);
        }

        return $this->sendResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $categories = Category::find($request->category_id);

        if (!$categories || count($categories) != count($request->category_id)) {
            return $this->sendError('Category not found!', 404);
        }

        $product = Product::create($request->validated());
        $product->categories()->saveMany($categories);

        return $this->sendResponse($product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->sendError('Product not found!', 404);
        }
        return $this->sendResponse($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return $this->sendError('Product not found!', 404);
        }
        return $this->sendResponse($product->forceDelete());
    }
}
