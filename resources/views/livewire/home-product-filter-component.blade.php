<div>
    <!-- product filter -->
    <section id="product">
        <div class="container">
          <div class="row">
            <!-- title -->
            <div class="col-12 text-center mb-4">
              <h5 class="mb-2">Discover Your Required Product</h5>
              <h2 class="fw-bold">From 267+ Different Vendors, 30+ Categories</h2>
            </div>

            <!-- filter buttons -->
            <div class="col-12 mb-5">
              <div class="flex flex-wrap align-items-center justify-content-center mx-auto gap-3">
                <a class="btn-md hot" href="#!">
                  <i class="fas fa-fire-alt"></i>
                  <span>Hot in Sale</span>
                </a>
                <button wire:click="filterByCategory(null)" class="btn btn-md hot">All Products</button>
                @foreach ($categories as $category)
                <button wire:click="filterByCategory({{ $category->id }})" class="btn btn-md {{ $selectedCategory === 
                $category->id ? 'hot' : '' }}">{{ $category->category_name }}</button>
                @endforeach
              </div>
            </div>

            @forelse($products as $product)
              
          
              
      
            

            <!-- products -->
            <div class="col-md-6 col-lg-4">
              <div class="card-md">
                <!-- image -->
                <div class="product-img">
                  <img src="{{ asset('home_asset/img/shoe.png') }}" alt="">
                  <img class="glow" src="{{ asset('home_asset/img/glow.png') }}" alt="">
                </div>

                <h4 class="fw-semibold mb-2">{{$product->product_name}}</h4>
                <h4 class="fw-light mb-4">$190.56</h4>

                <!-- add to cart -->
                <div class="add-cart-wrap">
                  <input type="number" value="1">
                  <a class="btn-md shadow-none" href="#!">Add to Cart</a>
                </div>

                <!-- cta -->
                <div class="card-md-cta">
                  <a href="#!">
                    <i class="fas fa-heart active"></i>
                  </a>

                  <a href="#!">
                    <i class="fa-solid fa-code-compare active"></i>
                  </a>
                </div>
              </div>
            </div>

            @empty

            <div class="col-12 tect-center">
              <h5>No product found for this category</h5>
            </div>

            @endforelse

          </div>
        </div>
      </section>
</div>
