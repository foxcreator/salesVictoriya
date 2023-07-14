@extends('layouts.app')
@section('content')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Добавление нового товара</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Наименование товара" required>
                                <label for="name">Наименование товара</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('description')is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" placeholder="Описание товара">
                                <label for="description">Описание товара</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('barcode')is-invalid @enderror" id="barcode" name="barcode" value="{{ old('barcode') }}" placeholder="Штрихкод">
                                <label for="barcode">Штрихкод</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('price')is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="Цена" required>
                                <label for="price">Цена розница (грн)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('opt_price')is-invalid @enderror" id="opt_price" name="opt_price" value="{{ old('opt_price') }}" placeholder="Цена оптовая" required>
                                <label for="price">Цена оптовая (грн)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('quantity')is-invalid @enderror" id="quantity" name="quantity"  value="{{ old('quantity') }}" placeholder="Количество товара на складе" required>
                                <label for="quantity">Количество товара на складе</label>
                            </div>
                            <label for="units" class="">Единицы измерения</label>
                            <select class="form-select mb-3" aria-label="units" name="unit">
                                @foreach($units as $unit)
                                    <option>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control @error('thumbnail')is-invalid @enderror" id="thumbnail" name="thumbnail" value="{{ old('thumbnail') }}">
                                <label class="input-group-text" for="thumbnail">Фото продукта</label>
                            </div>

                            <button type="submit" class="btn btn-outline-success">Добавить товар</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
@endsection
