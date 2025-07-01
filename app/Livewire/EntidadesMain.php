<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Entidad;

class EntidadesMain extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $entidades = Entidad::where('nombreEntidad', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
        return view('livewire.entidades-main', compact('entidades'));
    }
}
