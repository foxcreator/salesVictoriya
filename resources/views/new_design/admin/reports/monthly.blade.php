@extends('new_design.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Отчет с {{ $dates['ondate'] }} по {{ $dates['todate'] }}</div>
                    <div class="card-body">
                        <form class="row justify-content-center mt-3" action="{{ route('admin.reports.monthly') }}"
                              method="GET">
                            @csrf
                            <div class="col-auto">
                                <input type="date" class="form-control"
                                       data-target="#reservationdate"
                                       id="ondate" name="ondate" value="{{ $dates['ondate'] }}"
                                       max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-auto">
                                <input type="date" class="form-control"
                                       data-target="#reservationdate"
                                       id="todate" name="todate" value="{{ $dates['todate'] }}" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-dark mb-3">Выбрать период</button>
                            </div>
                        </form>
                        <table class="table table-hover text-nowrap">
                            <tr>

                                <th scope="col">Продаж за период</th>
                                <th scope="col">Доход</th>
                            </tr>
                            <tr>
                                <td class="align-top" rowspan="{{ count($productsSold) }}"><h2
                                        class="text-primary">{{ $totalSales }} грн</h2></td>
                                <td rowspan="{{ count($productsSold) }}"><h2
                                        class="text-success">{{ $totalSales - $totalOptSales }} грн</h2></td>
                            </tr>
                        </table>
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">Наименование</th>
                                <th scope="col">Сотрудник</th>
                                <th scope="col">Цена (розница)</th>
                                <th scope="col">Цена закупки</th>
                                <th scope="col">Продано(шт)</th>
                                <th scope="col">Сумма продажи</th>
                                <th scope="col">Валовая прибыль</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($productsSold as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


