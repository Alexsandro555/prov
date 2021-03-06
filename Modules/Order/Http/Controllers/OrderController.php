<?php

namespace Modules\Order\Http\Controllers;

use Modules\Order\Http\Requests\OrderRequest;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Order\Repositories\OrderRepository;
use Modules\Catalog\Entities\Product;
use Modules\Cart\Repositories\CartRepository;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\Mail;
use Modules\Order\Emails\OrderShipped;

class OrderController extends Controller
{
  /**
   * @var OrderRepository
   */
  private $orderRepository;
  /**
   * @var CartRepository
   */
  private $cartRepository;

  /**
   * OrderController constructor.
   */
  public function __construct(OrderRepository $orderRepository, CartRepository $cartRepository) {
    $this->orderRepository = $orderRepository;
    $this->cartRepository = $cartRepository;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index() {
    return view('order::index');
  }

  public function items() {
    return Order::with('user','products')->get();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view('order::create');
  }

  /**
   * Store a newly created resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function store(OrderRequest $request)
  {
    $cartProducts = $this->cartRepository->getAll()['products'];
    if($cartProducts->count() > 0) {
      $order = $this->orderRepository->create();
      foreach($cartProducts as $cartProduct) {
        $order->products()->attach($cartProduct->id, ['qty' => $cartProduct->qty, 'price' => $cartProduct->price]);
      }
      $this->cartRepository->deleteAll();
      Mail::to(config('info.manager_email'))->send(new OrderShipped($order));
      return $order;
    } else {
      return response()->json(['errors' => ['emptyCart' => 'Корзина не должна быть пустой']], 422);
    }
  }

  public function success($number)
  {
    return view('order::success', ['number' => $number]);
  }

  /**
   * Show the specified resource.
   * @return Response
   */
  public function show()
  {
    return view('order::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit()
  {
    return view('order::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function destroy()
  {
  }
}
