<!-- resources/views/components/memory-modal.blade.php -->
<div class="fixed inset-0 z-50 hidden items-center justify-center memory-modal" id="memoryModal">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeMemoryModal()"></div>
    <div class="bg-white rounded-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto relative z-10">
        <div class="relative">
            <button class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg z-10" onclick="closeMemoryModal()">
                <i class="fas fa-times text-gray-700"></i>
            </button>
            <img src="" alt="Memori" class="w-full h-96 object-cover rounded-t-xl" id="modalImage">
        </div>
        <div class="p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                    <img src="/api/placeholder/100/100" alt="Pengguna" class="w-full h-full object-cover">
                </div>
                <div>
                    <h3 class="font-bold" id="modalAuthor"></h3>
                    <p class="text-gray-500 text-sm" id="modalDate"></p>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2 mb-6" id="modalTags">
                <!-- Tags will be populated by JavaScript -->
            </div>
            
            <h2 class="text-3xl font-bold mb-4" id="modalTitle"></h2>
            <div class="prose max-w-none mb-8" id="modalContent">
                <!-- Content will be populated by JavaScript -->
            </div>
            
            <div class="border-t border-gray-200 pt-6">
                <h3 class="font-bold mb-4">Detail Lokasi</h3>
                <div class="flex items-center text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-green-500"></i>
                    <span id="modalLocation"></span>
                </div>
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-calendar-alt mr-2 text-green-500"></i>
                    <span id="modalTripDate"></span>
                </div>
                
                <div class="mt-6">
                    <div class="h-64 bg-gray-200 rounded-lg flex items-center justify-center" id="modalMap">
                        <i class="fas fa-map-marked-alt text-4xl text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="font-bold mb-4">Komentar</h3>
                <div class="space-y-4" id="modalComments">
                    <!-- Comments will be loaded here -->
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <p class="text-gray-500">Belum ada komentar untuk memori ini.</p>
                        <button class="mt-2 text-green-600 hover:text-green-800 font-medium">Jadilah yang pertama berkomentar</button>
                    </div>
                </div>
                
                <div class="mt-6">
                    <form id="commentForm" class="space-y-4">
                        <textarea class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" rows="3" placeholder="Bagikan pendapat Anda..."></textarea>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openMemoryModal(id, title, author, date, location, tripDate, tags, image, content) {
        // Parse tags JSON
        const tagArray = JSON.parse(tags);
        
        // Set modal content
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalAuthor').textContent = author;
        document.getElementById('modalDate').textContent = date;
        document.getElementById('modalLocation').textContent = location;
        document.getElementById('modalTripDate').textContent = tripDate;
        document.getElementById('modalImage').src = image;
        document.getElementById('modalContent').innerHTML = content;
        
        // Set tags
        const tagsContainer = document.getElementById('modalTags');
        tagsContainer.innerHTML = '';
        tagArray.forEach(tag => {
            const tagEl = document.createElement('span');
            tagEl.className = 'bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full';
            tagEl.textContent = tag;
            tagsContainer.appendChild(tagEl);
        });
        
        // Show modal
        const modal = document.getElementById('memoryModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }
    
    function closeMemoryModal() {
        const modal = document.getElementById('memoryModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = ''; // Re-enable scrolling
    }
    
    // Close modal when clicking Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeMemoryModal();
        }
    });
    
    // Prevent form submission
    document.getElementById('commentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Fitur komentar sedang dalam pengembangan.');
    });
</script>