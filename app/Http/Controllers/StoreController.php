<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StoreController extends Controller
{
    protected $baseUrl = 'https://petstore.swagger.io/v2';

    public function inventory()
    {
        $response = Http::get("{$this->baseUrl}/store/inventory");

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to fetch inventory'], 500);
        }

        $inventory = $response->json();
        return view('store.inventory', ['inventory' => $inventory]);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'petId' => 'required|integer',
            'quantity' => 'required|integer',
            'status' => 'required|string',
        ]);

        $response = Http::post("{$this->baseUrl}/store/order", [
            'petId' => $request->petId,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to place order'], 500);
        }

        return redirect('/store/orders/' . $response->json()['id']);
    }

    public function showOrder($id)
    {
        $response = Http::get("{$this->baseUrl}/store/order/{$id}");

        if ($response->failed()) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order = $response->json();
        return view('store.order', ['order' => $order]);
    }

    public function deleteOrder($id)
    {
        $response = Http::delete("{$this->baseUrl}/store/order/{$id}");

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to delete order'], 500);
        }

        return redirect('/store/inventory');
    }
}
