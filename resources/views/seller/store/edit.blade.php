@extends('seller.layouts.layout')
@section('seller_page_title')
Edit Store
@endsection
@section('seller_layout')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Store</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
                    <form action="{{ route('update.store', $store_info->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label for="store_name" class="fw-bold mb-2">Give Name of Your Store</label>
                        <input type="text" class="form-control" name="store_name" value="{{ $store_info->store_name }}">

                        <label for="slug" class="fw-bold mb-2">slug</label>
                        <input type="text" class="form-control" name="slug" value="{{ $store_info->slug }}">

                        <label for="details" class="fw-bold mb-2">Description of Your Store</label>
                        <textarea name="details" id="details" cols="30" rows="10" class="form-control">{{ $store_info->details }}</textarea>

                        <button type="submit" class="btn btn-primary w-100 mt-2">Update Store</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection