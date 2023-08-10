{{--@if(Auth::user()->role === 'admin')--}}
    @extends('new_design.layouts.admin')
@section('content')
    <div class="content-wrapper">

        <section class="content">

            <!-- Default box -->
                <div class="card card-solid">
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <form role="search">
                                    <div class="input-group">
                                        <input type="search" name="search" class="form-control form-control-lg" placeholder="Поиск товаров" aria-label="search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                    <div class="card-body pb-0">
                        @if($search)
                            <div class="container text-center mb-4">
                                <a class="btn btn-outline-secondary btn-sm" aria-current="page" href="{{ route('home') }}">Все
                                    товары</a>
                            </div>
                        @endif
                        <div class="row">
                            @foreach($products as $product)
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                <div class="card bg-light d-flex flex-fill">
                                    <div class="card-header text-muted border-bottom-0">
                                        {{ $product->category?->name }}
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class=""><b>{{ $product->name }}</b></h2>
                                            </div>
                                            <div class="col-7">
                                                <div class="description-block">

                                                    @if($product->description)
                                                        <p class="text-muted text-sm"><b>Описание: </b> {{ $product->description }} </p>
                                                    @endif
                                                </div>
                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                    <li class="small">
                                                        <h5><span class="fa-li"><i class="fas fa-warehouse"></i></span>Остаток:
                                                            @if($product->unit == 'шт.')
                                                                {{ (int) $product->quantity }} {{ $product->unit }}
                                                            @else
                                                                {{ $product->quantity }} {{ $product->unit }}
                                                            @endif
                                                            </h5>
                                                    </li>
                                                    <li class="small"><h5><span class="fa-li"><i
                                                                    class="fas fa-money-bill-alt"></i></span>Цена: {{ $product->price }}
                                                            грн</h5></li>
                                                </ul>
                                            </div>
                                            <div class="col-5 text-center m-auto">
                                                @if($product->thumbnailUrl !== '/storage/')
                                                    <img src="{{ $product->thumbnailUrl }}" class="img-circle img-fluid" alt="...">
                                                @else
                                                <img src="{{ asset('assets/img/NoImage.png') }}" alt="user-avatar"
                                                     class="img-circle img-fluid">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                            <form class="d-flex justify-content-between m-auto" action="{{ route('cart.add', $product) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $product->id }}">
                                                <input type="hidden" name="name" value="{{ $product->name }}">
                                                <input type="hidden" name="price" value="{{ $product->price }}">
                                                @if($product->quantity > 0)
                                                    <input type="text" class="col-md-4" name="quantity" value="1"
                                                           min="0" max="{{ $product->quantity }}">
                                                    <!-- Поле для выбора количества продукта -->
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-shopping-basket"></i> Добавить в чек
                                                    </button>
                                                @endif
                                            </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{ $products->links() }}

                    </div>
                <!-- /.card-body -->
                </div>
            <!-- /.card -->

        </section>

    </div>


@endsection
