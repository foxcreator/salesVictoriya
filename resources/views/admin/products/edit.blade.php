@extends('layouts.app')
@section('content')
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
                    <form action="{{ route('edit', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h4 class="mb-3">Выберите поставщика(ов):</h4>
                        <div class="row d-flex justify-content-center">
                            @foreach($suppliers as $supplier)
                                <div class="form-check form-switch text-start col-md-2 me-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           role="switch"
                                           name="supplier[]"
                                           value="{{ $supplier->id }}"
                                           id="supplier{{ $supplier->id }}"
                                           @if($product->suppliers->contains($supplier->id))
                                           checked @endif
                                    >
                                    <label class="form-check-label" for="supplier{{ $supplier->id }}"><h6>{{ $supplier->name }}</h6></label>
                                </div>
                            @endforeach
                        </div>
                        <select name="category_id" class="form-select mb-3 mt-3" aria-label="Category">
                            <option>--Выберите категорию--</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" placeholder="Наименование товара" value="{{ $product->name }}" required>
                            <label for="name">Наименование товара</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('description')is-invalid @enderror" id="description" name="description" placeholder="Описание товара" value="{{ $product->description }}">
                            <label for="description">Описание товара</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('barcode')is-invalid @enderror" id="barcode" name="barcode" value="{{ $product->barcode }}" placeholder="Штрихкод">
                            <label for="barcode">Штрихкод</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('price')is-invalid @enderror" id="price" name="price" value="{{ $product->price }}" placeholder="Цена" required>
                            <label for="price">Цена розница (грн)</label>
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control @error('thumbnail')is-invalid @enderror" id="thumbnail" name="thumbnail">
                            <label class="input-group-text" for="thumbnail">Фото продукта</label>
                        </div>

                        <button type="submit" class="btn btn-outline-success">Изменить товар</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

