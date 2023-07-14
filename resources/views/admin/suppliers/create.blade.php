@extends('layouts.app')
@section('content')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Добавление нового поставщика</div>

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
                        <form action="{{ route('admin.suppliers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Фирма поставщика" required>
                                <label for="name">Фирма поставщика</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('contact_info')is-invalid @enderror" id="contact_info" name="contact_info" value="{{ old('contact_info') }}" placeholder="Контакты">
                                <label for="contact_info">Контакты</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('deliver_name')is-invalid @enderror" id="deliver_name" name="deliver_name" value="{{ old('deliver_name') }}" placeholder="Торговый представитель">
                                <label for="deliver_name">Имя торгового представителя</label>
                            </div>

                            <button type="submit" class="btn btn-outline-success">Добавить поставщика</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
@endsection
