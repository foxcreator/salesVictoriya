@extends('new_design.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Редактирование товара {{ $product->name }}</div>

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
                        <form action="{{ route('admin.product.update', $product->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <label class="mb-3">Выберите поставщиков</label>
                            <div class="row d-flex justify-content-center">
                                <div class="form-group col-12">
                                    <select class="select2" name="supplier[]" multiple="multiple"
                                            data-placeholder="Выберете поставщиков" style="width: 100%;">
                                        @foreach($suppliers as $supplier)
                                            <option
                                                value="{{ $supplier->id }}"  {{ in_array($supplier->id, $product->suppliers->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for=>Категория</label>
                                <select name="category_id" class="form-control select2" aria-label="Category"
                                        style="width: 100%;">
                                    <option selected>--Выберите категорию--</option>
                                    @foreach($categories as $category)
                                        <option id="category_{{ $category->id }}"
                                                value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-floating mb-3 mt-4">
                                <label for="name">Наименование товара</label>
                                <input type="text" class="form-control @error('name')is-invalid @enderror" id="name"
                                       name="name" value="{{ $product->name }}" placeholder="Наименование товара" required>
                            </div>
                            <div class="form-floating mb-3">
                                <label for="description">Описание товара</label>
                                <input type="text" class="form-control @error('description')is-invalid @enderror"
                                       id="description" name="description" value="{{ $product->description }}"
                                       placeholder="Описание товара">
                            </div>
                            <div class="form-floating mb-3">
                                <label for="barcode">Штрихкод</label>
                                <input type="text" class="form-control @error('barcode')is-invalid @enderror"
                                       id="barcode" name="barcode" value="{{ $product->barcode }}" placeholder="Штрихкод">
                            </div>
                            <div class="form-floating mb-3">
                                <label for="price">Цена розничная (грн)</label>
                                <input type="text" class="form-control @error('price')is-invalid @enderror" id="price"
                                       name="price" value="{{ $product->price }}" placeholder="Цена" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="thumbnail">Фото продукта</label>
                                    <input type="file" class="custom-file-input @error('thumbnail')is-invalid @enderror"
                                           id="thumbnail" name="thumbnail" value="{{ old('thumbnail') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-success">Изменить товар</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

