@extends('new_design.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Добавление категории</div>

                    <div class="card-body col-md-10 m-auto">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-floating mb-3 mt-4">
                                <label for="name">Введите имя категории</label>
                                <input type="text" class="form-control @error('name')is-invalid @enderror" id="name"
                                       name="name" value="{{ old('name') }}" placeholder="Наименование категории">
                            </div>

                            <button type="submit" class="btn btn-outline-success">Добавить категорию</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
