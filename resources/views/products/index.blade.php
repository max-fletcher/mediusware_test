@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="{{ Request::fullUrl() }}" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">
                        <label for="id_label_single">
                            <option selected disabled value="">--Select A Variant--</option>
                            <optgroup label="Color">
                                <option value="red">Red</option>
                                <option value="black">Black</option>
                                <option value="green">Green</option>
                            </optgroup>
                            <optgroup label="Size">
                                <option value="xl">XL</option>
                                <option value="l">XL</option>
                                <option value="sm">SM</option>
                            </optgroup>
                            <optgroup label="Style">
                                <option value="v-nick">V-nick</option>
                                <option value="o-nick">O-nick</option>
                            </optgroup>
                        </label>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="number" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                        <input type="number" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->title }}<br> {{ $product->created_at->format('d-M-Y') }} </td>
                                <td style="width: 30% !important;">{{ $product->description }}</td>
                                <td>
                                    @foreach ($product->product_variant_prices as $price)
                                        <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                            <dt class="col-sm-3 pb-0">
                                                {{-- SM/ Red/ V-Nick --}}
                                                {{ isset($price->product_variant_one_belongs_to->variant) ? $price->product_variant_one_belongs_to->variant : '' }}
                                                {{ isset($price->product_variant_two_belongs_to->variant) ? ' / ' . $price->product_variant_two_belongs_to->variant : '' }}
                                                {{ isset($price->product_variant_three_belongs_to->variant) ? ' / ' . $price->product_variant_three_belongs_to->variant : '' }}
                                            </dt>
                                            <dd class="col-sm-9">
                                                <dl class="row mb-0">
                                                    <dt class="col-sm-4 pb-0">Price : {{ number_format($price->price, 2) }}</dt>
                                                    <dd class="col-sm-8 pb-0">InStock : {{ number_format($price->stock, 2) }}</dd>
                                                </dl>
                                            </dd>
                                        </dl>
                                    @endforeach
                                    <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $start_index }} to {{ $end_index }} out of {{ $all_products_count }} </p>
                </div>
                <div class="col-md-2">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
