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
                    <form action="{{ route('admin.stock.create') }}">
                        <button class="btn btn-outline-success">Новая поставка</button>
                    </form>
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
                                    <td>{{ $delivery->created_at }}</td>
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

