<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Favorite;
use App\Models\Movie; // 👈 Importamos el modelo de tu CRUD local

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // 🔍 Query y página para OMDb
        $query = $request->input('query', 'Batman');
        $page = (int) $request->input('page', 1);
        if ($page < 1) {
            $page = 1;
        }

        // 🎬 Llamada a OMDb API (10 resultados por página)
        $response = Http::get('http://www.omdbapi.com/', [
            'apikey' => env('OMDB_API_KEY'),
            's' => $query,
            'type' => 'movie',
            'page' => $page,
        ]);

        $data = $response->json();

        // 📌 Procesamos la respuesta de la API
        if (isset($data['Response']) && $data['Response'] === 'False') {
            $movies = [];
            $totalResults = 0;
            $error = $data['Error'] ?? 'Error desconocido al consultar la API';
        } else {
            $movies = $data['Search'] ?? [];
            $totalResults = isset($data['totalResults']) ? (int) $data['totalResults'] : count($movies);
            $error = null;
        }

        // ⭐ Favoritos del usuario
        $favorites = Favorite::where('user_id', $user->id)->paginate(10);

        // 🎞️ Películas locales del CRUD
        $myMovies = Movie::latest()->get();

        // 📄 Paginación para OMDb
        $perPage = 10;
        $totalPages = $perPage > 0 ? (int) ceil($totalResults / $perPage) : 1;

        // 🔹 Pasamos todo a la vista
        return view('dashboard', compact(
            'movies',       // Pelis externas (OMDb)
            'favorites',    // Favoritos del user
            'myMovies',     // Pelis locales (CRUD)
            'query',
            'page',
            'totalResults',
            'totalPages',
            'error'
        ));
    }
}
