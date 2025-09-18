<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <form action="{{ route('movies.search') }}" method="GET" class="flex gap-2">
            <input type="text" name="query" placeholder="Buscar películas..."
                   class="w-full px-4 py-2 border rounded-lg">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Buscar</button>
        </form>
    </div>
</x-app-layout>
