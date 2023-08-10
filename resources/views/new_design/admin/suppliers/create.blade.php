@extends('new_design.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card text-center">
                    <div class="card-header">Добавление нового поставщика</div>

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
                        <form action="{{ route('admin.suppliers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
{{--                                <label for="name">Фирма поставщика</label>--}}
                                <input type="text" class="form-control @error('name')is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Фирма поставщика" required>
                            </div>
                            <div class="form-floating mb-3">
{{--                                <label for="contact_info">Контакты</label>--}}
                                <input type="text" class="form-control @error('contact_info')is-invalid @enderror" id="contact_info" name="contact_info" value="{{ old('contact_info') }}" placeholder="Контакты">
                            </div>
                            <div class="form-floating mb-3">
{{--                                <label for="deliver_name">Имя торгового представителя</label>--}}
                                <input type="text" class="form-control @error('deliver_name')is-invalid @enderror" id="deliver_name" name="deliver_name" value="{{ old('deliver_name') }}" placeholder="Торговый представитель">
                            </div>

                            <button type="submit" class="btn btn-outline-success">Добавить поставщика</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
