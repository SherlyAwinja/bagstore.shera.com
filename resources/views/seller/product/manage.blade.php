@extends('seller.layouts.layout')
@section('seller_page_title')
Manage Product
@endsection
@section('seller_layout')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Products Added by You</h5>
                </div>

                @if (session('message'))
                    <div class="alert alert-success my-2">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->stock_quantity}}</td>
                                    <td>{{$product->regular_price}}</td>
                                    <td>
                                        <a href="{{ route('vendor.product.edit', $product->id) }}" class="btn btn-info">Edit</a>
                                        
                                        <form action="{{ route('vendor.product.delete', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">
                                        </form>
                                    </td>
                                </tr>
                                
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection