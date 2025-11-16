@extends('seller.layouts.layout')
@section('seller_page_title')
Manage Store
@endsection
@section('seller_layout')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Stores Created by You</h5>
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
                                    <th>Store Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stores as $store)
                                <tr>
                                    <td>{{$store->id}}</td>
                                    <td>{{$store->store_name}}</td>
                                    <td>{{$store->slug}}</td>
                                    <td>{{$store->details}}</td>
                                    <td>
                                        <a href="{{ route('show.store', $store->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('delete.store', $store->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this store?')">Delete</button>
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