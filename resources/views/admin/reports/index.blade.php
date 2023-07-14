@extends('layouts.app')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">Все товары</div>
                @if($employeeName)
                    <p><a href="{{ route('admin.reports') }}"
                          class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Назад</a>
                    </p>
                @endif
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
                            <th scope="col">Сотрудник</th>
                            <th scope="col">Цена (розница)</th>
                            <th scope="col">Цена закупки</th>
                            <th scope="col">Продано(шт)</th>
                            <th scope="col">Сумма продажи</th>
                            <th scope="col">Валовая прибыль</th>
                            <th scope="col">Продаж за день</th>
                            <th scope="col">Доход</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productsSold as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>
                                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                       href="{{ route('admin.reports', ['employee' => $product->employee_name]) }}">
                                        {{ $product->employee_name }}</a>
                                </td>
                                <td>{{ $product->price }} грн</td>
                                <td>{{ $product->opt_price }} грн</td>
                                <td>{{ $product->total_sold }}</td>
                                <td>{{ $product->total_sold * $product->price }} грн</td>
                                <td>{{($product->total_sold * $product->price) - ($product->total_sold * $product->opt_price) }}
                                    грн
                                </td>
                                @endforeach
                                <td class="align-top" rowspan="{{ count($productsSold) }}"><h2
                                        class="text-primary">{{ $totalSales }} грн</h2></td>
                                <td rowspan="{{ count($productsSold) }}"><h2
                                        class="text-success">{{ $totalSales - $totalOptSales }} грн</h2></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

