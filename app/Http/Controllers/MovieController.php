<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('movies.index', compact('movies'));
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'nullable|string|max:10',
            'director' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'poster' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();

        Movie::create($data);

        return redirect()->route('movies.index')->with('success', 'Película agregada correctamente');
    }

    public function edit(Movie $movie)
    {
        return view('movies.edit', compact('movie'));
    }

    public function update(Request $request, Movie $movie)
    {

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'nullable|string|max:10',
            'director' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'poster' => 'nullable|string',
        ]);

        $movie->update($data);

        return redirect()->route('movies.index')->with('success', 'Película actualizada correctamente');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Película eliminada correctamente');
    }
}
