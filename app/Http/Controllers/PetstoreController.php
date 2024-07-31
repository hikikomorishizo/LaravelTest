<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetstoreController extends Controller
{
    protected $baseUrl = 'https://petstore.swagger.io/v2';

    public function index()
    {
        $response = Http::get("{$this->baseUrl}/pet/findByStatus?status=available");
        
        if ($response->failed()) {
            return response()->json(['message' => 'Failed to fetch data'], 500);
        }

        return response()->json($response->json());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255'
        ]);

        $response = Http::post("{$this->baseUrl}/pet", [
            'name' => $request->name,
            'status' => $request->status
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to create pet'], 500);
        }

        return response()->json($response->json(), 201);
    }

    public function show($id)
    {
        $response = Http::get("{$this->baseUrl}/pet/{$id}");

        if ($response->failed()) {
            return response()->json(['message' => 'Pet not found'], 404);
        }

        return response()->json($response->json());
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|max:255'
        ]);

        $response = Http::post("{$this->baseUrl}/pet/{$id}", [
            'name' => $request->name,
            'status' => $request->status
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to update pet'], 500);
        }

        return response()->json($response->json());
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->baseUrl}/pet/{$id}");

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to delete pet'], 500);
        }

        return response()->json(['message' => 'Pet deleted']);
    }
}
