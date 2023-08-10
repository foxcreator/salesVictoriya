@extends('new_design.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Поставки</div>
                    <div class="card-body">
                        <div class="row align-items-center d-flex justify-content-around">
                            @if($search)
                                <div class="container d-flex justify-content-start mb-2">
                                    <a class="btn btn-sm btn-outline-secondary " aria-current="page"
                                       href="{{ route('admin.stock') }}">
                                        <i class="fas fa-arrow-circle-left"></i>
                                        Назад
                                    </a>
                                </div>
                            @endif
                                <form role="search" class="col-10">
                                    <div class="input-group">
                                        <input type="search" name="search" class="form-control form-control-lg" placeholder="Поиск товаров" aria-label="search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Фирма поставщика</th>
                                <th scope="col">Имя торгового представителя</th>
                                <th scope="col">Дата поставки</th>
                                <th scope="col">Сумма заказа</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($deliveries as $delivery)
                                <tr>
                                    <td>{{ $delivery->id }}</td>
                                    <td>{{ $delivery->suppliers->name }}</td>
                                    <td>{{ $delivery->suppliers->deliver_name }}</td>
                                    <td>{{ $delivery->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $delivery->total_amount }} грн</td>
                                    <td>
                                        <form action="{{ route('admin.stock.delivery', $delivery->id) }}" method="GET">
                                            <button class="btn btn-outline-info">Просмотреть</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

