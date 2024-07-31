<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetController extends Controller
{
    protected $baseUrl = 'https://petstore.swagger.io/v2';

    public function index(Request $request)
    {
        if ($request->has('search_id')) {
            $id = $request->input('search_id');
            
            if (empty($id) || !is_numeric($id)) {
                return redirect('/pets')->withErrors('Invalid ID');
            }

            return redirect("/pets/{$id}");
        }

        if ($request->has('search_name')) {
            $name = $request->input('search_name');
            
            if (empty($name)) {
                return redirect('/pets')->withErrors('Search term cannot be empty');
            }

            $response = Http::get("{$this->baseUrl}/pet/findByStatus?status=available");
            
            if ($response->failed()) {
                return response()->json(['message' => 'Failed to fetch data'], 500);
            }

            $pets = collect($response->json())->filter(function ($pet) use ($name) {
                return stripos($pet['name'], $name) !== false;
            });

            return view('pets.index', ['pets' => $pets->values()]);
        }

        $response = Http::get("{$this->baseUrl}/pet/findByStatus?status=available");
        
        if ($response->failed()) {
            return response()->json(['message' => 'Failed to fetch data'], 500);
        }

        $pets = $response->json();
        return view('pets.index', ['pets' => $pets]);
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

        return redirect('/pets');
    }

    public function show($id)
    {
        \Log::info('Fetching pet with ID: ' . $id);

        $response = Http::get("{$this->baseUrl}/pet/{$id}");

        if ($response->failed()) {
            return response()->json(['message' => 'Pet not found'], 404);
        }

        $pet = $response->json();
        return view('pets.show', ['pet' => $pet]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|max:255'
        ]);

        $response = Http::asForm()->post("{$this->baseUrl}/pet/{$id}", [
            'name' => $request->input('name'),
            'status' => $request->input('status')
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to update pet'], 500);
        }

        return redirect('/pets');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->baseUrl}/pet/{$id}");

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to delete pet'], 500);
        }

        return redirect('/pets');
    }

    public function edit($id)
    {
        \Log::info('Fetching pet with ID for editing: ' . $id);

        $response = Http::get("{$this->baseUrl}/pet/{$id}");

        if ($response->failed()) {
            return response()->json(['message' => 'Pet not found'], 404);
        }

        $pet = $response->json();
        return view('pets.edit', ['pet' => $pet]);
    }

    // Order
    public function createOrder(Request $request, $petId)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'shipDate' => 'required|date_format:Y-m-d\TH:i:s\Z',
            'status' => 'required|string',
            'complete' => 'required|boolean',
        ]);

        $response = Http::post("{$this->baseUrl}/store/order", [
            'petId' => $petId,
            'quantity' => $request->quantity,
            'shipDate' => $request->shipDate,
            'status' => $request->status,
            'complete' => $request->complete,
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to place order'], 500);
        }

        return redirect("/pets/{$petId}");
    }
}
