@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card text-center">
            <div class="card-header">Все товары</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">На витрине</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Цена оптовая</th>
                        <th scope="col">Цена розница</th>
                        <th scope="col">Остаток</th>
                        <th scope="col" colspan="2"></th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                    <tr>
                        <form action="{{ route('update', $product->id) }}" method="POST">
                            @csrf
                        <th scope="row">
                            @if($product->thumbnail)
                                <img class="img-thumbnail" style="width: 60px; height: 60px"  src="{{ $product->thumbnailUrl }}" alt="..." >
                            @endif
                        </th>
                        <td>{{ $product->on_sale }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->opt_price }}</td>
                        <td>
                            <input class="form-control text-center" type="text" name="price" value="{{ $product->price }}">
                        </td>
                        <td>
                            @if($product->unit == 'шт.')
                                {{ (int) $product->quantity }} {{ $product->unit }}
                            @else
                                {{ $product->quantity }} {{ $product->unit }}
                            @endif
                        </td>
                        <td class="w-50">
                        <div class="row d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-info col-md-2 me-2">Update</button>

                            <a href="{{ route('admin.edit', $product->id) }}" class="btn btn-outline-warning col-md-2 me-2">Edit</a>
                        </div>
                        </td>
                        </form>
                        <td>
                            <form action="{{ route('delete', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger col-md-12">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    {{ $products->links() }}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
