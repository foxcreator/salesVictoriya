@extends('new_design.layouts.app')
@section('content')
<div class="content-wrapper">
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
                    <form action="{{ route('admin.suppliers.create') }}">
                        <button class="btn btn-outline-success">Добавить нового поставщика</button>
                    </form>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">№</th>
                            <th scope="col">Фирма поставщика</th>
                            <th scope="col">Имя торгового представителя</th>
                            <th scope="col">Контакты</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->id }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->deliver_name }}</td>
                                <td>{{ $supplier->contact_info }}</td>
                                <td>
                                    <form action="{{ route('admin.suppliers.delete', $supplier->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-block bg-gradient-danger btn-sm">Удалить навсегда</button>
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

@endsection


