<x-app-layout>
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">✏️ Editar Película</h1>

        <form action="{{ route('movies.update', $movie) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold">Título</label>
                <input type="text" name="title" value="{{ old('title', $movie->title) }}"
                       class="w-full border px-3 py-2 rounded">
                @error('title') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold">Año</label>
                    <input type="text" name="year" value="{{ old('year', $movie->year) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block font-semibold">Director</label>
                    <input type="text" name="director" value="{{ old('director', $movie->director) }}"
                           class="w-full border px-3 py-2 rounded">
                </div>
            </div>

            <div>
                <label class="block font-semibold">Género</label>
                <input type="text" name="genre" value="{{ old('genre', $movie->genre) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="block font-semibold">Poster (URL)</label>
                <input type="text" name="poster" value="{{ old('poster', $movie->poster) }}"
                       class="w-full border px-3 py-2 rounded">
            </div>

            <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Actualizar
            </button>
            <a href="{{ route('movies.index') }}" class="ml-2 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>
