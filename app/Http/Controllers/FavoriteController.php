<?php

// app/Http/Controllers/FavoriteController.php
namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = Favorite::where('user_id', $request->user()->id)->get();
        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'imdb_id' => 'required',
            'title'   => 'required',
            'year'    => 'nullable',
            'poster'  => 'nullable',
        ]);

        Favorite::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'imdb_id' => $request->imdb_id,
            ],
            [
                'title'  => $request->title,
                'year'   => $request->year,
                'poster' => $request->poster,
            ]
        );

        return back()->with('success', 'Película agregada a favoritos');
    }

    public function destroy(Request $request, $id)
    {
        $favorite = Favorite::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $favorite->delete();

        return back()->with('success', 'Película eliminada de favoritos');
    }
}
