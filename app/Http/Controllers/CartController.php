<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\TemporaryCheckout;
use App\Services\CartService;
use Illuminate\Http\Request;
use function redirect;
use function session;
use function view;

class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = $this->cartService->getTotal();

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $this->cartService->addProductToCart($product, $request->quantity);

        return redirect()->back();
    }

    public function checkout(Request $request)
    {
        $data = $request->all();
        $cartId = $this->cartService->checkoutProductToDb($data);

        return redirect()->route('home')->with('success', "Менеджер вже оброблює ваш заказ.");
    }

    public function remove(Request $request, Product $product)
    {
        $product->removeFromCart();

        return redirect()->back();
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('home')->with('status', 'Корзина успешно очищена');
    }


    public function check()
    {
        $cart = session()->get('cart', []);
        $total = $this->cartService->getTotal();
        return view('checkout', compact('total', 'cart'));
    }

    public function temporaryCheckout(Request $request)
    {
        $data = $request->all();
        TemporaryCheckout::create($data);
    }

}

