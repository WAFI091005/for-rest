<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300" onclick="openMemoryModal('{{ $id }}', '{{ $title }}', '{{ $author }}', '{{ $date }}', '{{ $location }}', '{{ $tripDate }}', '{{ json_encode($tags) }}', '{{ $image }}', '{{ $content }}')">
    <div class="relative">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent p-4">
            <h3 class="text-white font-bold truncate">{{ $title }}</h3>
            <div class="flex items-center mt-1">
                <i class="fas fa-map-marker-alt text-green-400 text-xs mr-1"></i>
                <span class="text-gray-200 text-xs truncate">{{ $location }}</span>
            </div>
        </div>
    </div>
    <div class="p-4">
        <div class="flex items-center mb-3">
            <div class="w-8 h-8 rounded-full overflow-hidden mr-2">
                <img src="{{ $authorImage }}" alt="{{ $author }}" class="w-full h-full object-cover">
            </div>
            <div>
                <p class="text-sm font-medium">{{ $author }}</p>
                <p class="text-xs text-gray-500">{{ $date }}</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-1 mb-3">
            @foreach($tags as $tag)
                <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full">{{ $tag }}</span>
            @endforeach
        </div>
        <p class="text-gray-600 text-sm line-clamp-2">{{ $excerpt }}</p>
    </div>
</div>
