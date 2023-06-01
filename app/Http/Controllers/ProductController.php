<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $per_page = 2;

        $products = Product::with([
            'product_variant_prices.product_variant_one_belongs_to',
            'product_variant_prices.product_variant_two_belongs_to',
            'product_variant_prices.product_variant_three_belongs_to'
        ])->paginate($per_page);

        $all_products_count = Product::count();

        $start_page = $request->page ? ((int)$request->page)-1 : 0;
        $start_index = ($start_page*$per_page) + 1;
        $end_index = ($start_page+1 == $products->lastPage()) ? $all_products_count : (($start_page+1)*$per_page);

        // dd($start_page, $start_index, $end_index);

        // $products = Product::with([
        //         'product_variant_prices.product_variant_one',
        //         'product_variant_prices.product_variant_two',
        //         'product_variant_prices.product_variant_three'
        //     ])->where('id', '=', 5)->first();

        // dd($products);

        // foreach ($products as $product){
        //     foreach ($product->product_variant_prices as $prices){
        //         dd($prices->product_variant_one_belongs_to->variant);
        //     }
        // }

        // dd($products[0]);

        return view('products.index', compact('products', 'all_products_count', 'start_index', 'end_index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
