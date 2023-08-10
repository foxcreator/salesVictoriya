@extends('layouts.app')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">Склад</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Новая поставка</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.stock.store') }}">
                    @csrf

                    <!-- Выбор продуктов -->
                        <label for="products" class="mb-2 mt-3">Отметьте продукты в поставке</label>
                        @foreach ($products as $product)
                            <div class="input-group mb-2">
                                <div class="col-md-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" name="products[]"
                                               id="product{{ $product->id }}" value="{{ $product->id }}">
                                        <label class="form-check-label"
                                               for="product{{ $product->id }}">{{ $product->name }}</label>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex justify-content-between">
                                    <input type="text" class="form-control me-2 quantity-input @error('quantity.' . $product->id) is-invalid @enderror" id="quantity{{ $product->id }}"
                                           name="quantity[{{ $product->id }}]" placeholder="Количество">
                                    <input type="text" class="form-control me-2 purchase-price-input @error('purchasePrice.' . $product->id) is-invalid @enderror" id="purchasePrice{{ $product->id }}"
                                           name="purchase_price[{{ $product->id }}]" placeholder="Цена закупки">
                                    <input type="text" class="form-control retail-price-input @error('retailPrice.' . $product->id) is-invalid @enderror" id="retailPrice{{ $product->id }}"
                                           name="retail_price[{{ $product->id }}]" placeholder="Цена продажи">
                                    <input type="hidden" value="{{ $supplierId }}" name="supplier_id">
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-outline-success mt-4">Добавить поставку</button>

                    </form>
                    <a class="btn btn-outline-info mt-3" href="{{ route('admin.stock.first_step') }}">Назад</a>
                </div>
            </div>
        </div>

        <script>
            // Рассчитываем retailPrice на основе значения purchasePrice и добавляем 30
            function calculateChange(purchasePriceInput, retailPriceInput) {
                var purchaseAmount = parseFloat(purchasePriceInput.value);
                var changeAmount = purchaseAmount + (purchaseAmount * 0.3);

                if (isNaN(changeAmount)) {
                    changeAmount = 0;
                }

                var roundedAmount = Math.ceil(changeAmount / 5) * 5;
                retailPriceInput.value = roundedAmount.toFixed();
            }

            // Используем делегирование событий для расчета retailPrice при изменении purchasePrice
            document.addEventListener('input', function (event) {
                if (event.target.classList.contains('purchase-price-input')) {
                    var purchasePriceInput = event.target;
                    var retailPriceInput = purchasePriceInput.parentElement.querySelector('.retail-price-input');
                    calculateChange(purchasePriceInput, retailPriceInput);
                }
            });
        </script>


@endsection


