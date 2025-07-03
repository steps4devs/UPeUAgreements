<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Entidad;
use Illuminate\Support\Facades\Storage;

class EntidadesCRUD extends Component
{
    use WithFileUploads;

    public $entidadId = null;
    public $nombreEntidad, $ubicacion, $contacto, $logo, $logoPreview;

    public function mount($id = null)
    {
        if ($id) {
            $entidad = Entidad::findOrFail($id);
            $this->entidadId = $entidad->id;
            $this->nombreEntidad = $entidad->nombreEntidad;
            $this->ubicacion = $entidad->ubicacion;
            $this->contacto = $entidad->contacto;
            $this->logoPreview = $entidad->logo ? asset('storage/' . $entidad->logo) : null;
        } else {
            $this->reset(['entidadId', 'nombreEntidad', 'ubicacion', 'contacto', 'logo', 'logoPreview']);
        }
    }

    public function updatedLogo()
    {
        $this->validate([
            'logo' => 'nullable|image|max:10240', // Validar que sea una imagen y máximo 10 MB
        ]);

        // Si ya existe un logo, eliminarlo del almacenamiento
        if ($this->entidadId) {
            $entidad = Entidad::findOrFail($this->entidadId);
            if ($entidad->logo) {
                Storage::disk('public')->delete($entidad->logo); // Eliminar el archivo anterior
            }
        }

        // Subir el nuevo logo y actualizar la vista previa
        $this->logoPreview = $this->logo->store('logos', 'public');
        $this->logoPreview = asset('storage/' . $this->logoPreview);
    }

    public function save()
    {
        $this->validate([
            'nombreEntidad' => 'required|string|max:200',
            'ubicacion' => 'required|string|max:200',
            'contacto' => 'required|string|max:100',
        ]);

        if ($this->entidadId) {
            $entidad = Entidad::findOrFail($this->entidadId);

            // Eliminar el logo anterior si se subió uno nuevo
            if ($this->logoPreview && $entidad->logo) {
                Storage::disk('public')->delete($entidad->logo);
            }

            $entidad->update([
                'nombreEntidad' => $this->nombreEntidad,
                'ubicacion' => $this->ubicacion,
                'contacto' => $this->contacto,
                'logo' => $this->logoPreview ? str_replace(asset('storage/'), '', $this->logoPreview) : $entidad->logo,
            ]);
        } else {
            Entidad::create([
                'nombreEntidad' => $this->nombreEntidad,
                'ubicacion' => $this->ubicacion,
                'contacto' => $this->contacto,
                'logo' => $this->logoPreview ? str_replace(asset('storage/'), '', $this->logoPreview) : null,
            ]);
        }

        return redirect()->route('entidades-main');
    }

    public function render()
    {
        return view('livewire.entidades-crud');
    }
}