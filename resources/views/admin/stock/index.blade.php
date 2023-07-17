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
                    <div class="row align-items-center d-flex justify-content-around">
                    <form class="col-md-4" action="{{ route('admin.stock.first_step') }}">
                        <button class="btn btn-outline-success">Новая поставка</button>
                    </form>
                        @if($search)
                            <div class="container text-center col-md-4">
                                <a class="btn btn-outline-success " aria-current="page" href="{{ route('admin.stock') }}">Все поставки</a>
                            </div>
                        @endif
                        <form class="d-flex mt-3 mb-3 col-md-4" role="search">
                            <input class="form-control me-2" type="search" name="search" placeholder="Поиск по названию"
                                   aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                    </div>
                        <table class="table">
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


@endsection

