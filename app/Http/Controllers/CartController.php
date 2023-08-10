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
        $data = TemporaryCheckout::select('check_id')->distinct()->get()->pluck('check_id');
        $checkCount = TemporaryCheckout::distinct('check_id')->count();

        return view('new_design.cart.index',
            compact('cart', 'total', 'checkCount', 'data'
            ));
    }

    public function indexDelayed($checkId)
    {
        $cart = TemporaryCheckout::where('check_id', $checkId)->get();
        $checkCount = TemporaryCheckout::distinct('check_id')->count();
        $data = TemporaryCheckout::select('check_id')->distinct()->get()->pluck('check_id');

        $idCheck = $checkId;
        $total = 0;
        foreach ($cart as $item) {
            $total += $item->price * $item->quantity;
        }

        return view('new_design.cart.index',
            compact('cart', 'total', 'checkCount', 'data', 'idCheck'
            ));
    }

    public function add(Request $request, Product $product)
    {
        $this->cartService->addProductToCart($product, $request->quantity);

        return redirect()->back();
    }

    public function checkout(Request $request)
    {
        $hiddenInputs = $request->all();
        $isDelayed = $hiddenInputs['isDelayed'];
//        $delayedCheckId = $hiddenInputs['check_id'];
        $cartId = $this->cartService->checkoutProductToDb($isDelayed);

        return redirect()->route('home')->with('success', "Чек #{$cartId} закрыт");
    }

    public function checkoutTemporary($checkId)
    {
        $cartId = $this->cartService->saveIntoTemporary($checkId);

        return redirect()->route('home')->with('status', "Чек #{$cartId} закрыт");
    }

    public function remove(Request $request, Product $product)
    {
        $isChecked = $request->all();
        if (isset($isChecked['delayed'])) {
            $isDelete = $product->removeFromTemporaryCartDb($product);
            if ($isDelete == true){
                return redirect()->route('cart')->with('status', "$product->name удален из чека");
            } else {
                return redirect()->back()->with('status', "$product->name удален из чека");
            }

        } else {
            $product->removeFromCart();
            return redirect()->back()->with('status', "$product->name удален из чека");
        }

    }

    public function clear(Request $request)
    {
        $isChecked = $request->all();
        if (isset($isChecked['delayed'])) {
            TemporaryCheckout::query()->where('check_id', $isChecked['check_id'])->delete();
        } else {
            session()->forget('cart');
        }


        return redirect()->route('home')->with('status', 'Корзина успешно очищена');
    }


    public function check()
    {
        $cart = session()->get('cart', []);
        $total = $this->cartService->getTotal();
        return view('checkout', compact('total', 'cart'));
    }



}

