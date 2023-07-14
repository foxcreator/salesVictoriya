@extends('layouts.app')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">Поставки</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Штрихкод</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Цена постаки</th>
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
                </div>
            </div>
        </div>


@endsection

