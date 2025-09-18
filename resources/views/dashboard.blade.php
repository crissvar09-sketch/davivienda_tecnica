<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        {{-- Formulario de búsqueda --}}
        <div class="max-w-2xl mx-auto mb-8">
            <form action="{{ route('external-movies.search') }}" method="GET" class="flex gap-2">
                <input type="text" name="query" placeholder="Buscar películas..." value="{{ $query !== 'Batman' ? $query : '' }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition font-medium">
                    🔍 Buscar
                </button>
            </form>
        </div>

        {{-- Título dinámico basado en si hay búsqueda o no --}}
        @if($query && $query !== 'Batman')
            <h1 class="text-3xl font-bold mb-6 text-gray-800">🔍 Resultados para: "{{ $query }}"</h1>
        @else
            <h1 class="text-3xl font-bold mb-6 text-gray-800">🎬 Películas Recomendadas</h1>
        @endif

        <div class="flex justify-between items-center mb-6">
            <div>
                @if($query && $query !== 'Batman')
                    <p class="text-gray-600">Mostrando resultados de búsqueda</p>
                @else
                    <p class="text-gray-600">Películas populares de la API</p>
                @endif
            </div>

            {{-- 🎬 Link para crear películas locales --}}
            <a href="{{ route('movies.index') }}"
               class="bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition">
                Mis películas CRUD
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse ($movies as $movie)
                <div class="bg-white shadow-md rounded-xl p-4 flex flex-col items-center hover:shadow-lg transition">
                    <img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/200x300' }}"
                         alt="{{ $movie['Title'] }}"
                         class="w-32 h-48 object-cover rounded-md mb-3">

                    <h2 class="text-lg font-semibold text-center text-gray-900">{{ $movie['Title'] }}</h2>
                    <p class="text-sm text-gray-500 mb-2">{{ $movie['Year'] }}</p>

                    <form method="POST" action="{{ route('favorites.store') }}" class="w-full">
                        @csrf
                        <input type="hidden" name="imdb_id" value="{{ $movie['imdbID'] }}">
                        <input type="hidden" name="title" value="{{ $movie['Title'] }}">
                        <input type="hidden" name="year" value="{{ $movie['Year'] }}">
                        <input type="hidden" name="poster" value="{{ $movie['Poster'] }}">

                        <button
                            class="mt-2 w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition">
                            + Agregar a Favoritos
                        </button>
                    </form>
                </div>
            @empty
                <p class="col-span-4 text-center text-gray-500">No se encontraron películas</p>
            @endforelse
        </div>

        {{-- Paginación --}}
        <div class="flex justify-center mt-8 space-x-4">
            @if ($page > 1)
                <a href="{{ route('dashboard', ['page' => $page - 1, 'query' => $query]) }}"
                   class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800">
                    ← Anterior
                </a>
            @endif

            @if ($totalResults > $page * 10)
                <a href="{{ route('dashboard', ['page' => $page + 1, 'query' => $query]) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Siguiente →
                </a>
            @endif
        </div>

        {{-- Favoritos --}}
        <h1 class="text-3xl font-bold mt-12 mb-6 text-gray-800">⭐ Tus Favoritos</h1>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse ($favorites as $fav)
                <div class="bg-gray-100 shadow-md rounded-xl p-4 flex flex-col items-center hover:shadow-lg transition">
                    <img src="{{ $fav->poster !== 'N/A' ? $fav->poster : 'https://via.placeholder.com/200x300' }}"
                         alt="{{ $fav->title }}"
                         class="w-32 h-48 object-cover rounded-md mb-3">

                    <h2 class="text-lg font-semibold text-center text-gray-900">{{ $fav->title }}</h2>
                    <p class="text-sm text-gray-500 mb-2">{{ $fav->year }}</p>

                    <form method="POST" action="{{ route('favorites.destroy', $fav->id) }}" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button
                            class="mt-2 w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow transition">
                            ✖ Quitar
                        </button>
                    </form>
                </div>
            @empty
                <p class="col-span-4 text-center text-gray-500">No tienes películas en favoritos</p>
            @endforelse
        </div>

    </div>
</x-app-layout>
