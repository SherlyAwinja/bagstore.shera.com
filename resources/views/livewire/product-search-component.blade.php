<form wire:submit.prevent>
  <div class="search-bar">
    <input type="text" wire:model.debounce.300ms="query" placeholder="Search Product..." required>
    <div class="search-icon">
      <i class="fas fa-search"></i>
    </div>
  </div>
</form>

@if(!empty($results))
  <ul class="search-results">
    @foreach($results as $product)
      <li>{{ $product['product_name'] ?? '' }}</li>
    @endforeach
  </ul>
@endif