<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikeNotification extends Component
{
    public $showNotification = false;

    protected $listeners = ['likeAdded' => 'showNotification'];

    public function showNotification()
    {
        $this->showNotification = true;

        // Sembunyikan setelah 5 detik (opsional)
        $this->dispatchBrowserEvent('hide-notification', ['timeout' => 5000]);
    }

    public function render()
    {
        return view('livewire.like-notification');
    }
}

