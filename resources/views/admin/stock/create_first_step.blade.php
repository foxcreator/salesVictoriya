@extends('layouts.app')
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header">Склад</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h1>Новая поставка</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="stock-form" method="GET" action="{{ route('admin.stock.create') }}">
                    @csrf

                    <!-- Выбор поставщика -->
                        <label for="suppliers" class="mb-2">Выберите поставщика</label>
                        <select id="suppliers" class="form-select" name="supplier_id">
                            <option value="---">-выберите поставщика-</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" id="submit-btn" class="btn btn-outline-success mt-4">Добавить поставку</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
