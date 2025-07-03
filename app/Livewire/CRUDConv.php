<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Convenio;
use App\Models\DocumentoConvenio;
use App\Models\Entidad;
use App\Models\Facultad;
use App\Models\Carrera;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CRUDConv extends Component
{
    use WithFileUploads;

    public $convenioId = null;
    public $nombreConvenio, $descripcion, $fecha_inicio, $fecha_fin, $estado, $alcance, $convenio_id_entidad, $facultad_id, $carrera_id;
    public $entidades = [];
    public $facultades = [];
    public $carreras = [];
    public $clausulas = []; // Archivos que se están subiendo
    public $clausulas_acumuladas = [];
    public $archivos_guardados = []; // Almacena los documentos subidos
    public $showEntidadForm = false; // Controla la visibilidad del formulario de entidad
    public $entidadId = null; // Declarar la propiedad para manejar la entidad
    public $nombreEntidad, $ubicacion, $contacto, $logo, $logoPreview;

    protected $listeners = ['archivoSubido' => 'actualizarArchivosGuardados'];

    public function mount($id = null)
    {
        $this->entidades = \App\Models\Entidad::all();
        $this->facultades = \App\Models\Facultad::all();
        $this->carreras = [];

        $this->convenioId = $id;

        if ($id) {
            $convenio = \App\Models\Convenio::with('documentos')->findOrFail($id);
            $this->nombreConvenio = $convenio->nombreConvenio;
            $this->descripcion = $convenio->descripcion;
            $this->fecha_inicio = $convenio->fecha_inicio->format('Y-m-d');
            $this->fecha_fin = $convenio->fecha_fin->format('Y-m-d');
            $this->estado = $convenio->estado;
            $this->alcance = $convenio->alcance;
            $this->convenio_id_entidad = $convenio->convenio_id_entidad;
            $this->facultad_id = $convenio->facultad_id;
            $this->carrera_id = $convenio->carrera_id;

            // Cargar documentos existentes
            $this->archivos_guardados = $convenio->documentos->toArray();
            if ($this->facultad_id) {
                $this->carreras = \App\Models\Carrera::where('facultad_id', $this->facultad_id)->get();
            }
        } else {
            $this->nombreConvenio = '';
            $this->descripcion = '';
            $this->fecha_inicio = '';
            $this->fecha_fin = '';
            $this->estado = '';
            $this->alcance = '';
            $this->convenio_id_entidad = null;
            $this->facultad_id = null;
            $this->carrera_id = null;
            $this->archivos_guardados = [];
        }
    }

    protected function rules()
    {
        $rules = [
            'nombreConvenio' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date',
            'alcance' => 'required|string|max:50',
            'convenio_id_entidad' => 'required|integer',
        ];

        if ($this->alcance === 'Facultad' || $this->alcance === 'Carrera') {
            $rules['facultad_id'] = 'required|integer';
        } else {
            $rules['facultad_id'] = 'nullable|integer';
        }

        if ($this->alcance === 'Carrera') {
            $rules['carrera_id'] = 'required|integer';
        } else {
            $rules['carrera_id'] = 'nullable|integer';
        }

        $rules['clausulas.*'] = 'file|max:10240';

        return $rules;
    }

    public function updatedFacultadId($value)
    {
        if ($value) {
            $this->carreras = Carrera::where('facultad_id', $value)->get();
        } else {
            $this->carreras = [];
            $this->carrera_id = null;
        }
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
                'convenio_id'     => $this->convenioId,
                'ruta'            => $path,
            ]);
        }

        // Recargar documentos subidos
        $this->archivos_guardados = DocumentoConvenio::where('convenio_id', $this->convenioId)->get()->toArray();
    }

    public function eliminarArchivo($key)
    {
        unset($this->clausulas_acumuladas[$key]); // Eliminar archivo por clave
        $this->clausulas_acumuladas = array_values($this->clausulas_acumuladas); // Reindexar el array
    }

    public function eliminarArchivoGuardado($id)
    {
        $doc = DocumentoConvenio::find($id);
        if ($doc) {
            Storage::delete($doc->ruta);
            $doc->delete();
        }
        // Refresca la lista
        $this->archivos_guardados = Convenio::with('documentos')->find($this->convenioId)->documentos->toArray();
    }

    public function save()
    {
        $this->validate();

        // Calcular estado automáticamente
        $estado = 'Vigente';
        if ($this->fecha_fin) {
            $hoy = now()->startOfDay();
            $fin = \Carbon\Carbon::parse($this->fecha_fin)->startOfDay();
            $dias = $hoy->diffInDays($fin, false);

            if ($fin->lt($hoy)) {
                $estado = 'Vencido';
            } elseif ($dias <= 30) {
                $estado = 'Por vencer';
            }
        }

        $convenio = $this->convenioId
            ? Convenio::findOrFail($this->convenioId)
            : new Convenio();

        $convenio->nombreConvenio = $this->nombreConvenio;
        $convenio->descripcion = $this->descripcion;
        $convenio->fecha_inicio = $this->fecha_inicio;
        $convenio->fecha_fin = $this->fecha_fin;
        $convenio->estado = $estado;
        $convenio->alcance = $this->alcance;
        $convenio->convenio_id_entidad = $this->convenio_id_entidad;
        $convenio->facultad_id = ($this->alcance === 'Facultad' || $this->alcance === 'Carrera') ? $this->facultad_id : null;
        $convenio->carrera_id = ($this->alcance === 'Carrera') ? $this->carrera_id : null;
        $convenio->convenio_creador = Auth::id();
        $convenio->save();

        // Guardar archivos acumulados
        if ($this->clausulas_acumuladas && is_array($this->clausulas_acumuladas)) {
            foreach ($this->clausulas_acumuladas as $archivo) {
                $mime = $archivo->getClientMimeType();
                $tipo = str_contains($mime, 'pdf') ? 'PDF' : (str_contains($mime, 'image') ? 'Imagen' : 'Otro');
                $path = $archivo->store('clausulas');
                DocumentoConvenio::create([
                    'nombreArchivo'   => $archivo->getClientOriginalName(),
                    'tipo_documento'  => $tipo,
                    'fecha_subida'    => now()->toDateString(),
                    'hora_subida'     => now()->toTimeString(),
                    'convenio_id'     => $convenio->id,
                    'ruta'            => $path,
                ]);
            }
        }

        // Limpiar
        $this->reset(['clausulas', 'clausulas_acumuladas']);
        $this->archivos_guardados = Convenio::with('documentos')->find($convenio->id)->documentos->toArray();
        session()->flash('success', 'Convenio guardado correctamente.');
        return redirect()->route('convenios-main');
    }

    public function actualizarArchivosGuardados()
    {
        if ($this->convenioId) {
            $this->archivos_guardados = \App\Models\Convenio::with('documentos')->find($this->convenioId)->documentos->toArray();
        }
    }

    public function openEntidadForm()
    {
        $this->reset(['entidadId', 'nombreEntidad', 'ubicacion', 'contacto', 'logo', 'logoPreview']);
        $this->showEntidadForm = true;
    }

    public function closeEntidadForm()
    {
        $this->showEntidadForm = false;
    }

    public function updatedLogo()
    {
        $this->validate([
            'logo' => 'nullable|image|max:10240', // Validar que sea una imagen y máximo 10 MB
        ]);

        $this->logoPreview = $this->logo->store('logos', 'public');
        $this->logoPreview = asset('storage/' . $this->logoPreview);
    }

    public function saveEntidad()
    {
        $this->validate([
            'nombreEntidad' => 'required|string|max:200',
            'ubicacion' => 'required|string|max:200',
            'contacto' => 'required|string|max:100',
            'logo' => 'nullable|image|max:10240',
        ]);

        $logoPath = $this->logo ? $this->logo->store('logos', 'public') : null;

        Entidad::create([
            'nombreEntidad' => $this->nombreEntidad,
            'ubicacion' => $this->ubicacion,
            'contacto' => $this->contacto,
            'logo' => $logoPath,
        ]);

        $this->closeEntidadForm();
        $this->entidades = Entidad::all(); // Refrescar el listado de entidades
    }

    public function render()
    {
        return view('livewire.c-r-u-d-conv', [
            'entidades' => Entidad::all(),
        ]);
    }
}
