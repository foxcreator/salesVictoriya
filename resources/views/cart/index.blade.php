@extends('layouts.app')
@section('content')
    {{--    @dd(session()->get('delayed_checks'))--}}
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card text-center">
                <div class="card-header">Открытый чек</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($checkCount >= 1)
                        <div class="mt-3">
                            <h5>Чеки:</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('cart') }}"
                                   class="btn btn-outline-info {{ Request::is('cart') ? 'active' : '' }}">
                                    Текущий чек
                                </a>
                                @foreach ($data as $checkId => $check)

                                    <a href="{{ route('cart.indexDelayed', $check) }}"
                                       class="btn btn-outline-info {{ Request::route('checkId') == $check ? 'active' : '' }}">
                                        Отложенный чек #{{ $check }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($cart)

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Наименование</th>
                                <th scope="col">Цена</th>
                                <th scope="col">Кол-во</th>
                                <th scope="col">Сумма</th>
                                <th scope="col">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <th scope="row">{{ $item['id'] }}</th>
                                    <td>
                                        @if (is_object($item) && $item->product)
                                            {{ $item->product->name }}
                                        @else
                                            {{ $item['name'] }}
                                        @endif
                                    </td>
                                    <td>{{ $item['price'] }} грн</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>{{ $item['price'] * $item['quantity'] }} грн</td>
                                    <td>
                                        @if (is_object($item) && $item->product)
                                            <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                                                <input type="hidden" name="delayed" value="1">
                                                <button class="btn btn-danger">Удалить 1 шт.</button>
                                                @csrf
                                            </form>
                                        @else
                                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                                <button class="btn btn-danger">Удалить 1 шт.</button>
                                                @csrf
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><h4>Итого:</h4></td>
                                <td><h4>{{ $total }}</h4></td>


                            </tr>
                            </tbody>

                        </table>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                            Очистить все
                        </button>

                        <button type="button" class="btn btn-success w-25 ms-3" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                            Расчет
                        </button>
                        @if(Request::route('checkId'))

                        @else
                            <form class="d-flex text-end" action="{{ route('cart.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="isDelayed" value="1">
                                <button type="submit" class="btn btn-success w-25 ms-3">
                                    Отложить чек
                                </button>
                            </form>
                        @endif
                    @else
                        <h4>Добавте товар в чек</h4>
                    @endif


                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->


    <!-- Modal Clear -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Подтверждение</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Очистка удалит весь товар из чека. Вы уверены?
                </div>
                <div class="modal-footer">

                    @if(is_object($cart))
                        <form action="{{ route('cart.clear') }}" method="POST">

                            @csrf
                            <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Отмена</button>
                            <input type="hidden" name="delayed" value="1">
                            <input type="hidden" name="check_id" value="{{ $idCheck }}">
                            <button class="btn btn-danger" type="submit">Очистить корзину</button>
                        </form>
                    @else
                    <form action="{{ route('cart.clear') }}" method="POST">

                        @csrf
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Отмена</button>

                        <button class="btn btn-danger" type="submit">Очистить корзину</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <h1>Калькулятор сдачи</h1>

                        <div class="form-group">
                            <label for="purchase-amount">Сумма покупки:</label>
                            <input type="number" class="form-control" id="purchase-amount" value="{{ $total }}"
                                   readonly>
                        </div>

                        <div class="form-group">
                            <label for="payment-amount">Сумма клиента:</label>
                            <input type="number" class="form-control" id="payment-amount" step="0.01"
                                   oninput="calculateChange()">
                        </div>

                        <div class="form-group">
                            <label for="change-amount">Сдача:</label>
                            <input type="text" class="form-control" id="change-amount" readonly>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                @if(isset($idCheck))
                        <form action="{{ route('cart.checkout.temporary', $idCheck) }}" method="POST">
                        @csrf
                        <input type="hidden" name="check_id" value="{{ $idCheck }}">
                        <button class="btn btn-success" type="submit">Оплата</button>
                    </form>
                    @else
                        <form action="{{ route('cart.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="isDelayed" value="0">
                            <button class="btn btn-success" type="submit">Оплата</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        function calculateChange() {
            var purchaseAmount = parseFloat(document.getElementById('purchase-amount').value);
            var paymentAmount = parseFloat(document.getElementById('payment-amount').value);
            var changeAmount = paymentAmount - purchaseAmount;

            if (isNaN(changeAmount)) {
                changeAmount = 0;
            }

            document.getElementById('change-amount').value = changeAmount.toFixed(2);
        }
    </script>


@endsection
