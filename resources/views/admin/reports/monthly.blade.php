@extends('layouts.app')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">Отчет с {{ $dates['ondate'] }} по {{ $dates['todate'] }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form class="row justify-content-end" action="{{ route('admin.reports.calcmonthly') }}" method="GET">
                            @csrf
                            <div class="col-auto">
                                <label for="ondate" class="visually-hidden">Email</label>
                                <input type="date" class="form-control" id="ondate" name="ondate" value="{{ $dates['ondate'] }}" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-auto">
                                <label for="todate" class="visually-hidden">Password</label>
                                <input type="date" class="form-control" id="todate" name="todate" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-dark mb-3">Выбрать даты</button>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Наименование</th>
                                <th scope="col">Цена (розница)</th>
                                <th scope="col">Цена закупки</th>
                                <th scope="col">Продано(шт)</th>
                                <th scope="col">Сумма продажи</th>
                                <th scope="col">Валовая прибыль</th>
                                <th scope="col">Продаж за период</th>
                                <th scope="col">Доход</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($productsSold as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }} грн</td>
                                    <td>{{ $product->opt_price }} грн</td>
                                    <td>{{ $product->total_sold }}</td>
                                    <td>{{ $product->total_sold * $product->price }} грн</td>
                                    <td>{{($product->total_sold * $product->price) - ($product->total_sold * $product->opt_price) }} грн</td>
                                    @endforeach
                                    <td rowspan="{{ count($productsSold) }}"><h2 class="text-dark">{{ $totalSales }} грн</h2></td>
                                    <td rowspan="{{ count($productsSold) }}"><h2 class="text-success">{{ $totalSales - $totalOptSales }} грн</h2></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection


