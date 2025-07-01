<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Importar el trait
use App\Models\Entidad;

class EntidadesCRUD extends Component
{
    use WithFileUploads; // Usar el trait para habilitar la subida de archivos

    public $entidadId = null;
    public $nombreEntidad, $ubicacion, $contacto, $logo;

    public function mount($id = null)
    {
        if ($id) {
            $entidad = Entidad::findOrFail($id);
            $this->entidadId = $entidad->id;
            $this->nombreEntidad = $entidad->nombreEntidad;
            $this->ubicacion = $entidad->ubicacion;
            $this->contacto = $entidad->contacto;
            $this->logo = $entidad->logo;
        } else {
            $this->reset(['entidadId', 'nombreEntidad', 'ubicacion', 'contacto', 'logo']);
        }
    }

    public function save()
    {
        $this->validate([
            'nombreEntidad' => 'required|string|max:200',
            'ubicacion' => 'required|string|max:200',
            'contacto' => 'required|string|max:100',
            'logo' => 'nullable|image|max:10240', // Validar que sea una imagen y máximo 10 MB
        ]);

        if ($this->logo) {
            $this->logo = $this->logo->store('logos', 'public'); // Guardar el archivo en storage/app/public/logos
        }

        if ($this->entidadId) {
            $entidad = Entidad::findOrFail($this->entidadId);
            $entidad->update([
                'nombreEntidad' => $this->nombreEntidad,
                'ubicacion' => $this->ubicacion,
                'contacto' => $this->contacto,
                'logo' => $this->logo ?? $entidad->logo,
            ]);
        } else {
            Entidad::create([
                'nombreEntidad' => $this->nombreEntidad,
                'ubicacion' => $this->ubicacion,
                'contacto' => $this->contacto,
                'logo' => $this->logo,
            ]);
        }

        return redirect()->route('entidades-main');
    }

    public function render()
    {
        return view('livewire.entidades-crud');
    }
}