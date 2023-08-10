@extends('new_design.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">Склад</div>
                <div class="card-body">
                    <h3>Новая поставка от {{ $supplier->name }}</h3>
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
                        <label for="products" class="mb-2 mt-3" id="productsLabel">Отметьте продукты в поставке</label>                        @foreach ($products as $product)
                            <div class="input-group mb-2">
                                <div class="col-md-3 text-left">
                                    <div class="icheck-success d-inline">
                                        <input class="form-check-input product-checkbox" type="checkbox" name="products[]"
                                               id="product{{ $product->id }}" value="{{ $product->id }}">
                                        <label class="form-check-label" for="product{{ $product->id }}">{{ $product->name }}</label>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex justify-content-between">
                                    <input type="text" class="form-control me-2 quantity-input @error('quantity.' . $product->id) is-invalid @enderror" id="quantity{{ $product->id }}"
                                           name="quantity[{{ $product->id }}]" placeholder="Количество" disabled>
                                    <input type="text" class="form-control me-2 purchase-price-input @error('purchasePrice.' . $product->id) is-invalid @enderror" id="purchasePrice{{ $product->id }}"
                                           name="purchase_price[{{ $product->id }}]" placeholder="Цена закупки" disabled>
                                    <input type="text" class="form-control retail-price-input @error('retailPrice.' . $product->id) is-invalid @enderror" id="retailPrice{{ $product->id }}"
                                           name="retail_price[{{ $product->id }}]" placeholder="Цена продажи" disabled>
                                    <input type="hidden" value="{{ $supplierId }}" name="supplier_id">
                                </div>
                            </div>
                        @endforeach
{{--                        <div class="row d-flex align-items-center">--}}
                            <a class="btn btn-outline-secondary mt-3" href="{{ route('admin.stock.first_step') }}">Назад</a>
                            <button type="submit" class="btn btn-outline-success mt-3">Добавить поставку</button>
{{--                        </div>--}}
                    </form>
                </div>
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

        $(document).ready(function() {
            $('.product-checkbox').on('change', function() {
                var isChecked = $(this).prop('checked');
                var inputFields = $(this).closest('.input-group').find('.form-control');

                // Если чекбокс выбран, активируем поля ввода, иначе - деактивируем
                inputFields.prop('disabled', !isChecked);

                // Изменяем текст label в зависимости от состояния чекбокса
                var label = isChecked ? 'Введите количество и цены выбранных продуктов' : 'Отметьте продукты в поставке';
                $('#productsLabel').text(label);
            });
        });

    </script>


@endsection


