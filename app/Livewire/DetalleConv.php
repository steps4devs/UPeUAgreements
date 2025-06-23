<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Convenio;

class DetalleConv extends Component
{
    public $convenio;
    public $ambito_1;
    public $ambito_2;
    public $ambito_3;
    public $mensaje = null;
    public $notificaciones = [];

    public function mount($id)
    {
        $this->convenio = \App\Models\Convenio::findOrFail($id);
        $this->ambito_1 = $this->convenio->ambito_1;
        $this->ambito_2 = $this->convenio->ambito_2;
        $this->ambito_3 = $this->convenio->ambito_3;
    }

    public function guardarAmbito($numero)
    {
        if ($numero == 1) {
            $this->convenio->ambito_1 = $this->ambito_1;
            $this->convenio->save();
            $this->dispatch('notificar', message: 'Ámbito 1 guardado correctamente.');
        }
        if ($numero == 2) {
            $this->convenio->ambito_2 = $this->ambito_2;
            $this->convenio->save();
            $this->dispatch('notificar', message: 'Ámbito 2 guardado correctamente.');
        }
        if ($numero == 3) {
            $this->convenio->ambito_3 = $this->ambito_3;
            $this->convenio->save();
            $this->dispatch('notificar', message: 'Ámbito 3 guardado correctamente.');
        }
    }

    public function render()
    {
        return view('livewire.detalle-conv');
    }
}
