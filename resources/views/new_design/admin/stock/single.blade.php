@extends('new_design.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Поставка №{{ $delivery->id }}
                        от {{ $delivery->created_at->format('Y-m-d') }}</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.stock') }}">
                                <i class="fas fa-arrow-circle-left"></i>
                                Назад
                            </a>
                        </div>
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">Штрихкод</th>
                                <th scope="col">Наименование</th>
                                <th scope="col">Цена поставки</th>
                                <th scope="col">Розничная цена</th>
                                <th scope="col">Кол-во</th>
                                <th scope="col">Сумма заказа</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->barcode }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->pivot->purchase_price }}</td>
                                    <td>{{ $product->pivot->retail_price }}</td>
                                    <td>
                                        @if($product->unit == 'шт.')
                                            {{ (int) $product->pivot->quantity }} {{ $product->unit }}
                                        @else
                                            {{ $product->pivot->quantity }} {{ $product->unit }}
                                        @endif
                                    </td>
                                    <td>{{ $product->pivot->purchase_price * $product->pivot->quantity }} грн</td>
                                    <td></td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="container">
                            <div class="d-flex justify-content-end mt-3">
                                <h4 class="text-gray-dark">Сумма заказа: {{ $totalAmount }}грн</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

