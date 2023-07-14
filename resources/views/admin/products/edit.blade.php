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
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" placeholder="Наименование товара" value="{{ $product->name }}" required>
                            <label for="name">Наименование товара</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('description')is-invalid @enderror" id="description" name="description" placeholder="Описание товара" value="{{ $product->description }}" required>
                            <label for="description">Описание товара</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('price')is-invalid @enderror" id="price" name="price" placeholder="Цена" value="{{ $product->price }}" required>
                            <label for="price">Цена(€)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('quantity')is-invalid @enderror" id="quantity" name="quantity" placeholder="Количество товара на складе" value="{{ $product->quantity }}" required>
                            <label for="quantity">Количество товара на складе</label>
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control @error('thumbnail')is-invalid @enderror" id="thumbnail" name="thumbnail">
                            <label class="input-group-text" for="thumbnail">Фото продукта</label>
                        </div>

                        <button type="submit" class="btn btn-outline-success">Добавить товар</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

