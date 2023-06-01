<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // dd($request);

        $title = $request->title ?? null;
        $variant = $request->variant ?? null;
        $price_from = $request->price_from ?? null;
        $price_to = $request->price_to ?? null;
        $date = $request->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $request->date) : null;

        // dd($request->all(), $title, $price_from, $price_to, $date);

        $per_page = 3;

        $products = Product::with(['product_variant_prices.product_variant_one_belongs_to', 
                                    'product_variant_prices.product_variant_two_belongs_to',
                                    'product_variant_prices.product_variant_three_belongs_to'
                                ])
                                ->when($title, function($q1)use($title){
                                    $q1->where('title', 'LIKE', '%'.$title.'%');
                                })
                                ->when($variant, function($q2)use($variant){
                                    $q2->wherehas('product_variants', function($q3)use($variant){
                                        return $q3->where('variant', $variant);
                                    });
                                })
                                ->when($price_from, function($q4)use($price_from){
                                    $q4->wherehas('product_variant_prices', function($q5)use($price_from){
                                        return $q5->where('price', '>=', $price_from);
                                    });
                                })
                                ->when($price_to, function($q6)use($price_to){
                                    $q6->wherehas('product_variant_prices', function($q7)use($price_to){
                                        return $q7->where('price', '<=', $price_to);
                                    });
                                })
                                ->when($date, function($q7)use($date){
                                    $q7->whereDate('created_at', $date);
                                })
                                ->paginate($per_page);

        // Pagination Data
        $all_products_count = Product::when($title, function($q1)use($title){
            $q1->where('title', 'LIKE', '%'.$title.'%');
        })
        ->when($variant, function($q2)use($variant){
            $q2->wherehas('product_variants', function($q3)use($variant){
                return $q3->where('variant', $variant);
            });
        })
        ->when($price_from, function($q4)use($price_from){
            $q4->wherehas('product_variant_prices', function($q5)use($price_from){
                return $q5->where('price', '>=', $price_from);
            });
        })
        ->when($price_to, function($q6)use($price_to){
            $q6->wherehas('product_variant_prices', function($q7)use($price_to){
                return $q7->where('price', '<=', $price_to);
            });
        })
        ->when($date, function($q7)use($date){
            $q7->whereDate('created_at', $date);
        })->count();

        $start_page = $request->page ? ((int)$request->page)-1 : 0;
        if($all_products_count == 0){
            $start_index = 0;
        }
        else{
            $start_index = ($start_page*$per_page) + 1;
        }
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
        dd($request->all());
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
