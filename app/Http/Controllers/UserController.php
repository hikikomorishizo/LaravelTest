<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    protected $baseUrl = 'https://petstore.swagger.io/v2';

    public function index()
    {
        return view('users.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
            'userStatus' => 'nullable|integer',
        ]);

        $userData = [
            'username' => $request->input('username'),
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'phone' => $request->input('phone'),
            'userStatus' => $request->input('userStatus'),
        ];

        $response = Http::post($this->baseUrl . '/user', $userData);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'User created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create user.');
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $username = $request->input('username');

        $response = Http::get($this->baseUrl . "/user/{$username}");

        if ($response->successful()) {
            $user = $response->json();
            return view('users.search', ['user' => $user]);
        } elseif ($response->status() == 404) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to retrieve user.');
        }
    }

    public function update(Request $request, $username)
    {
        $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
            'userStatus' => 'nullable|integer',
        ]);

        $userData = [
            'firstName' => $request->input('firstName'),
            'lastName' => $request->input('lastName'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'phone' => $request->input('phone'),
            'userStatus' => $request->input('userStatus'),
        ];

        $response = Http::put($this->baseUrl . "/user/{$username}", $userData);

        if ($response->successful()) {
            return redirect()->route('users.search', ['username' => $username])->with('success', 'User updated successfully.');
        } elseif ($response->status() == 404) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        } else {
            return redirect()->route('users.search', ['username' => $username])->with('error', 'Failed to update user.');
        }
    }

    public function destroy($username)
    {
        $response = Http::delete($this->baseUrl . "/user/{$username}");

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } elseif ($response->status() == 404) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        } else {
            return redirect()->route('users.index')->with('error', 'Failed to delete user.');
        }
    }
}
