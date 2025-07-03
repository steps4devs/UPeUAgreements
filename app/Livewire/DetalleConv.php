<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Convenio;
use App\Models\DocumentoConvenio;

class DetalleConv extends Component
{
    use WithFileUploads;

    public $convenio;
    public $ambito_1;
    public $ambito_2;
    public $ambito_3;
    public $mensaje = null;
    public $notificaciones = [];
    public $archivos_guardados = [];
    public $clausulas = [];

    public function mount($id)
    {
        $this->convenio = \App\Models\Convenio::with('documentos')->findOrFail($id);
        $this->ambito_1 = $this->convenio->ambito_1;
        $this->ambito_2 = $this->convenio->ambito_2;
        $this->ambito_3 = $this->convenio->ambito_3;

        // Cargar documentos existentes
        $this->archivos_guardados = $this->convenio->documentos->toArray();
    }

    public function updatedClausulas($files)
    {
        foreach ($files as $file) {
            // Guardar archivo en el almacenamiento
            $path = $file->store('clausulas', 'public');

            // Determinar el tipo de archivo
            $mime = $file->getClientMimeType();
            $tipo = str_contains($mime, 'pdf') ? 'PDF' : (str_contains($mime, 'image') ? 'Imagen' : 'Otro');

            // Guardar en la base de datos
            DocumentoConvenio::create([
                'nombreArchivo'   => $file->getClientOriginalName(),
                'tipo_documento'  => $tipo,
                'fecha_subida'    => now()->toDateString(),
                'hora_subida'     => now()->toTimeString(),
                'convenio_id'     => $this->convenio->id,
                'ruta'            => $path,
            ]);
        }

        // Recargar documentos subidos
        $this->archivos_guardados = DocumentoConvenio::where('convenio_id', $this->convenio->id)->get()->toArray();
    }

    public function eliminarArchivoGuardado($id)
    {
        $documento = DocumentoConvenio::findOrFail($id);
        \Storage::disk('public')->delete($documento->ruta);
        $documento->delete();

        // Recargar documentos subidos
        $this->archivos_guardados = DocumentoConvenio::where('convenio_id', $this->convenio->id)->get()->toArray();
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
        return view('livewire.detalle-conv', [
            'convenio' => $this->convenio,
            'archivos_guardados' => $this->archivos_guardados,
        ]);
    }
}
