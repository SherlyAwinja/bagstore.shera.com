@extends('layouts.user')

@section('home')
    <!-- breadcrumb -->
    <div class="container">
      <div class="row">
        <div class="col-12">
          <p class="breadcrumb-title">Home > <span>Shoe</span></p>
        </div>
      </div>
    </div>

    <!-- main contents -->
    <main>
      <!-- product filter -->
      <section>
        <div class="container">
          <div class="row">

            <div class="col-12 d-block d-lg-none">
              <a class="filter-btn" href="#!">
                <span>Filters</span>
                <i class="fa-solid fa-sliders"></i>
              </a>
            </div>

            <!-- filters -->
            <div class="col-lg-4 filters-wrap">

              <a class="d-block d-lg-none filter-close" href="#!">
                <i class="fa-regular fa-rectangle-xmark"></i>
              </a>

              <!-- category -->
              <div class="filter-card">
                <h5 class="mb-3">Product Category</h5>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="accessories">
                  <label class="form-check-label" for="accessories">
                    Bags
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="beauty">
                  <label class="form-check-label" for="beauty">
                    Organizers
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="electronics">
                  <label class="form-check-label" for="electronics">
                    Backpacks
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="fashion">
                  <label class="form-check-label" for="fashion">
                    Luggage
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="kids">
                  <label class="form-check-label" for="kids">
                    Kids
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="sports">
                  <label class="form-check-label" for="sports">
                    Gym Bags
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="watches">
                  <label class="form-check-label" for="watches">
                    Travel Bags
                  </label>
                </div>
              </div>

              <!-- price range -->
              <div class="filter-card">
                <h5 class="mb-3">Price Filter</h5>

                <!-- range -->
                <input type="range" class="form-range mb-2" id="">

                <!-- button -->
                <div class="flex flex-wrap align-items-center justify-content-between gap-3">
                  <a class="btn-sm" href="#!">Filter</a>

                  <p>Price: $0 - $1,040</p>
                </div>
              </div>

              <!-- product status -->
              <div class="filter-card">
                <h5 class="mb-3">Product Status</h5>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="in-stock">
                  <label class="form-check-label" for="in-stock">
                    In Stock
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="on-sale">
                  <label class="form-check-label" for="on-sale">
                    On Sale
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="discontinued">
                  <label class="form-check-label" for="discontinued">
                    Discontinued
                  </label>
                </div>
              </div>

              <!-- By Shop -->
              <div class="filter-card">
                <h5 class="mb-3">Product Status</h5>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    Shera Bags Store
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    Mama Watoto Supermarket
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    XYZ Shop
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    Asib's Shop
                  </label>
                </div>

                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    Shakib's Shop
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="">
                  <label class="form-check-label" for="">
                    XYZ Shop
                  </label>
                </div>
              </div>
            </div>

            <!-- products -->
            <div class="col-lg-8 mb-5">
              <div class="row">
                @forelse($products as $product)
              

                <!-- products -->
                <div class="col-md-6 col-lg-4">
                  <div class="card-md">
                    <!-- image -->
                    <div class="product-img">
                      <img src="{{ asset('storage/'.$product->images->first()?->image_path ?? 'placeholder.png') }}" alt="">
                      <img class="glow" src="{{ asset('home_asset/img/glow.png') }}" alt="">
                    </div>
    
                    <h4 class="fw-semibold mb-2">{{$product->product_name}}</h4>
                    <h4 class="fw-light mb-4">${{ $product->discounted_price, 2 }}</h4>
    
                    <!-- add to cart -->
                    <div class="add-cart-wrap" x-data="{ 
                      quantity: 1,
                      addToCart() {
                        const cartData = {productId: {{ $product->id }}, quantity: Number(this.quantity)};
                        console.log('Adding to cart:', cartData);
                        // Use both Alpine dispatch and direct function call
                        $dispatch('addToCartFromAnywhere', cartData);
                        if (typeof window.dispatchAddToCart === 'function') {
                          window.dispatchAddToCart(cartData);
                        }
                      }
                    }">
                      <input type="number" min="1" max="{{ $product->stock_quantity }}" x-model.number="quantity" value="1" aria-label="Quantity for {{ $product->product_name }}">
                      <button type="button" class="btn-md shadow-none" @click="addToCart()">Add to Cart</button>
                    </div>
    
                    <!-- cta -->
                    <div class="card-md-cta">
                      <a href="#!" aria-label="Add to favorites">
                        <i class="fas fa-heart active"></i>
                      </a>
    
                      <a href="#!" aria-label="Compare product">
                        <i class="fa-solid fa-code-compare active"></i>
                      </a>
                    </div>
                  </div>
                </div>
    
                @empty
    
                <div class="col-12 text-center">
                  <h5>No product found for this category</h5>
                </div>
    
                @endforelse

              </div>
            </div>
          </div>
        </div>
      </section>
@endsection