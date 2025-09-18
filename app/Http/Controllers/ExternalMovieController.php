<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExternalMovieController extends Controller
{
    public function searchForm()
    {
        // Vista con el formulario de búsqueda
        return view('movies.search');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return redirect()->route('dashboard')->with('error', 'Debes ingresar un término de búsqueda.');
        }

        // Redirigir al dashboard con el parámetro de búsqueda
        return redirect()->route('dashboard', ['query' => $query]);
    }
}
