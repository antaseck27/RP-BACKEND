<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        return response()->json(
            Hotel::where('user_id', $userId)->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:120',
            'phone' => 'required|string|max:30',
            'price_per_night' => 'required|numeric',
            'currency' => 'required|string|max:5',
            'image' => 'nullable|image|max:4096',
        ]);

        $hotel = new Hotel($validated);
        $hotel->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $hotel->image = $request->file('image')->store('hotels', 'public');
        }

        $hotel->save();

        return response()->json($hotel, 201);
    }

    public function show(Hotel $hotel)
    {
        if ($hotel->user_id !== auth()->id()) {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        return response()->json($hotel);
    }

    public function update(Request $request, Hotel $hotel)
    {
        if ($hotel->user_id !== auth()->id()) {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:120',
            'phone' => 'required|string|max:30',
            'price_per_night' => 'required|numeric',
            'currency' => 'required|string|max:5',
            'image' => 'nullable|image|max:4096',
        ]);

        $hotel->fill($validated);

        if ($request->hasFile('image')) {
            $hotel->image = $request->file('image')->store('hotels', 'public');
        }

        $hotel->save();

        return response()->json($hotel);
    }

    public function destroy(Hotel $hotel)
    {
        if ($hotel->user_id !== auth()->id()) {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        $hotel->delete();
        return response()->json(['message' => 'Supprimé']);
    }
}
