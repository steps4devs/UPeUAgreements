<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DocumentoConvenio;
use Illuminate\Support\Facades\Storage;

class DocumentoUploader extends Component
{
    use WithFileUploads;

    public $convenioId;
    public $archivo;

    public function updatedArchivo()
    {
        try {
            if (!$this->convenioId) {
                $this->dispatch('notify', type: 'error', message: 'Debe guardar el convenio antes de subir archivos.');
                $this->dispatch('limpiarInputArchivo');
                $this->archivo = null;
                return;
            }

            $mime = $this->archivo->getClientMimeType();
            $tipo = str_contains($mime, 'pdf') ? 'PDF' : (str_contains($mime, 'image') ? 'Imagen' : 'Otro');
            $path = $this->archivo->store('clausulas');

            DocumentoConvenio::create([
                'nombreArchivo'   => $this->archivo->getClientOriginalName(),
                'tipo_documento'  => $tipo,
                'fecha_subida'    => now()->toDateString(),
                'hora_subida'     => now()->toTimeString(),
                'convenio_id'     => $this->convenioId,
                'ruta'            => $path,
            ]);

            $this->dispatch('notify', type: 'success', message: 'Archivo subido correctamente.');
            $this->dispatch('limpiarInputArchivo');
            $this->archivo = null;
            $this->dispatch('archivoSubido');
        } catch (\Throwable $e) {
            $this->dispatch('notify', type: 'error', message: 'Error al subir archivo: '.$e->getMessage());
            $this->dispatch('limpiarInputArchivo');
            $this->archivo = null;
        }
    }

    public function render()
    {
        return view('livewire.documento-uploader');
    }
}
