<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">🎬 Mis Películas</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('movies.create') }}"
           class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            ➕ Agregar Película
        </a>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($movies as $movie)
                <div class="bg-white shadow rounded p-3 flex flex-col items-center">
                    <img src="{{ $movie->poster ?? 'https://via.placeholder.com/150x220' }}"
                         alt="{{ $movie->title }}"
                         class="w-32 h-48 object-cover mb-2 rounded">
                    <h2 class="text-lg font-semibold text-center">{{ $movie->title }}</h2>
                    <p class="text-sm text-gray-500">{{ $movie->year }} - {{ $movie->genre }}</p>
                    <p class="text-sm text-gray-400 italic">{{ $movie->director }}</p>

                    <div class="flex gap-2 mt-2">
                        <a href="{{ route('movies.edit', $movie) }}"
                           class="px-3 py-1 bg-yellow-400 text-white rounded text-sm hover:bg-yellow-500">
                            ✏️ Editar
                        </a>
                        <form action="{{ route('movies.destroy', $movie) }}" method="POST"
                              onsubmit="return confirm('¿Seguro que deseas eliminar esta película?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">
                                ❌ Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-4 text-center text-gray-500">No has agregado películas aún.</p>
            @endforelse
        </div>

        <div class="mt-6">

        </div>
    </div>
</x-app-layout>
