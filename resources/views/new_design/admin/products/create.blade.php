@extends('new_design.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Добавление нового товара</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="mb-3">Выберите поставщиков</label>
                            <div class="row d-flex justify-content-center">
                                <div class="form-group col-12">
                                    <select class="select2" name="supplier[]" multiple="multiple"
                                            data-placeholder="Выберете поставщиков" style="width: 100%;">
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for=>Категории</label>
                                <select name="category_id" class="form-control select2" aria-label="Category"
                                        style="width: 100%;">
                                    <option selected>--Выберите категорию--</option>
                                    @foreach($categories as $category)
                                        <option id="category_{{ $category->id }}"
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-floating mb-3 mt-4">
                                <label for="name">Наименование товара</label>
                                <input type="text" class="form-control @error('name')is-invalid @enderror" id="name"
                                       name="name" value="{{ old('name') }}" placeholder="Наименование товара" required>
                            </div>
                            <div class="form-floating mb-3">
                                <label for="description">Описание товара</label>
                                <input type="text" class="form-control @error('description')is-invalid @enderror"
                                       id="description" name="description" value="{{ old('description') }}"
                                       placeholder="Описание товара">
                            </div>
                            <div class="form-floating mb-3">
                                <label for="barcode">Штрихкод</label>
                                <input type="text" class="form-control @error('barcode')is-invalid @enderror"
                                       id="barcode" name="barcode" value="{{ old('barcode') }}" placeholder="Штрихкод">
                            </div>
                            <div class="form-floating mb-3">
                                <label for="price">Цена оптовая (грн)</label>
                                <input type="text" class="form-control @error('opt_price')is-invalid @enderror"
                                       id="opt_price" name="opt_price" value="{{ old('opt_price') }}"
                                       placeholder="Цена оптовая" required>
                            </div>
                            <div class="form-floating mb-3">
                                <label for="price">Цена розничная (грн)</label>
                                <input type="text" class="form-control @error('price')is-invalid @enderror" id="price"
                                       name="price" value="{{ old('price') }}" placeholder="Цена" required>
                            </div>
                            <div class="form-floating mb-3">
                                <label for="quantity">Количество товара на складе</label>
                                <input type="text" class="form-control @error('quantity')is-invalid @enderror"
                                       id="quantity" name="quantity" value="{{ old('quantity') }}"
                                       placeholder="Количество товара на складе" required>
                            </div>
                            <div class="form-group">
                                <label for="units" class="">Единицы измерения</label>
                                <select name="unit" class="form-control select2" aria-label="units"
                                        style="width: 100%;">
                                    @foreach($units as $unit)
                                        <option id="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="thumbnail">Фото продукта</label>
                                    <input type="file" class="custom-file-input @error('thumbnail')is-invalid @enderror"
                                           id="thumbnail" name="thumbnail" value="{{ old('thumbnail') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-success">Добавить товар</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
