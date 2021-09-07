<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Order::with('orderItems.product')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $orderFields = new Collection($request->validated());
        $orderItemsFields = new Collection($orderFields->pull('orderItems'));

        $order = Order::create($orderFields->all());
        $orderItemsFields->each(fn(array $item) => $order->orderItems()->create($item));

        return response()->json($order->load('orderItems.product'));
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json($order->load('orderItems.product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $orderFields = new Collection($request->validated());
        $orderItemsFields = new Collection($orderFields->pull('orderItems'));

        $order->update($orderFields->all());

        if ($orderItemsFields->isNotEmpty()) {
            $order->orderItems()->delete();
            $orderItemsFields->each(fn(array $item) => $order->orderItems()->create($item));
        }

        return response()->json($order->load('orderItems.product'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Order $order): JsonResponse
    {
        DB::transaction(function () use ($order) {
            $order->orderItems()->delete();
            $order->delete();
        });

        return response()->json('ok');
    }
}
