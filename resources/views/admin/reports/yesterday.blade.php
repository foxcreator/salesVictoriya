@extends('layouts.app')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">Все товары</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Наименование</th>
                            <th scope="col">Цена за единицу</th>
                            <th scope="col">Продано(шт)</th>
                            <th scope="col">Сумма продажи</th>
                            <th scope="col">Прибыль за день</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productsSold as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}€</td>
                                <td>{{ $product->total_sold }}</td>
                                <td>{{ $product->total_sold * $product->price}}€</td>
                                @endforeach
                                <td rowspan="{{ count($productsSold) }}"><h2 class="text-success">{{ $totalSales }}€</h2></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

