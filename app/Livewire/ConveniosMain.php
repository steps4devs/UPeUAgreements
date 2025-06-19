<?php
namespace App\Livewire;

use App\Models\Carrera;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Convenio;
use App\Models\DocumentoConvenio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConveniosMain extends Component
{
    use WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $modalOpen = false;
    public $editing = false;
    public $convenioId;
    public $nombreConvenio, $descripcion, $fecha_inicio, $fecha_fin, $estado, $alcance, $convenio_id_entidad, $facultad_id, $carrera_id;

    public $entidades = [];
    public $facultades = [];
    public $carreras = [];
    public $clausulas = [];
    public $clausulas_acumuladas = [];
    public $archivos_guardados = [];

    public $modalEditArchivosOpen = false;
    public $convenioIdEditArchivos = null;

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

    public function mount()
    {
        $this->entidades = \App\Models\Entidad::all();
        $this->facultades = \App\Models\Facultad::all();
        $this->carreras = [];
    }

    public function render()
    {
        $convenios = Convenio::with(['entidad', 'facultad', 'carrera'])
            ->where('nombreConvenio', 'like', '%'.$this->search.'%')
            ->orderBy('updated_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.convenios-main', compact('convenios'));
    }

    public function openModal($id = null)
    {
        $this->reset(['clausulas', 'clausulas_acumuladas', 'archivos_guardados']);
        $this->modalOpen = true;
        $this->editing = false;

        if ($id) {
            $this->editing = true;
            $this->convenioId = $id;
            $convenio = Convenio::with('documentos')->findOrFail($id);
            $this->nombreConvenio = $convenio->nombreConvenio;
            $this->descripcion = $convenio->descripcion;
            $this->fecha_inicio = $convenio->fecha_inicio;
            $this->fecha_fin = $convenio->fecha_fin;
            $this->estado = $convenio->estado;
            $this->alcance = $convenio->alcance;
            $this->convenio_id_entidad = $convenio->convenio_id_entidad;
            $this->facultad_id = $convenio->facultad_id;
            $this->carreras = Carrera::where('facultad_id', $this->facultad_id)->get();
            $this->carrera_id = $convenio->carrera_id;
            $this->archivos_guardados = $convenio->documentos->toArray();
        }
    }

    public function save()
    {
        try {
            $this->validate();

            // Calcular estado
            $estado = null;
            if ($this->fecha_fin) {
                $hoy = now()->startOfDay();
                $fin = \Carbon\Carbon::parse($this->fecha_fin)->startOfDay();
                $dias = $hoy->diffInDays($fin, false);

                if ($fin->lt($hoy)) {
                    $estado = 'Vencido';
                } elseif ($dias <= 30) {
                    $estado = 'Por vencer';
                } else {
                    $estado = 'Vigente';
                }
            } else {
                $estado = 'Vigente';
            }

            $convenio = $this->editing && $this->convenioId
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

            // Guardar archivos de cláusulas en la base de datos (solo si hay archivos nuevos)
            if ($this->clausulas_acumuladas && is_array($this->clausulas_acumuladas)) {
                foreach ($this->clausulas_acumuladas as $archivo) {
                    $mime = $archivo->getClientMimeType();
                    if (str_contains($mime, 'pdf')) {
                        $tipo = 'PDF';
                    } elseif (str_contains($mime, 'image')) {
                        $tipo = 'Imagen';
                    } else {
                        $tipo = 'Otro';
                    }

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

            $this->modalOpen = false;
            $this->editing = false;
            $this->reset(['convenioId', 'clausulas', 'clausulas_acumuladas']);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            throw $e;
        }
    }

    public function delete($id)
    {
        Convenio::findOrFail($id)->delete();
    }

    public function updatedAlcance($value)
    {
        $this->facultad_id = null;
        $this->carrera_id = null;
        $this->carreras = [];
    }

    public function updatedFacultadId($value)
    {
        if ($value) {
            $this->carreras = \App\Models\Carrera::where('facultad_id', $value)->get();
        } else {
            $this->carreras = [];
            $this->carrera_id = null;
        }
    }

    public function updatedClausulas($files)
    {
        foreach ($files as $file) {
            $this->clausulas_acumuladas[] = $file;
        }
        $this->clausulas = [];
    }

    public function eliminarArchivo($key)
    {
        unset($this->clausulas_acumuladas[$key]);
        $this->clausulas_acumuladas = array_values($this->clausulas_acumuladas);
    }

    public function cerrarModal()
    {
        $this->modalOpen = false;
        $this->editing = false;
        $this->reset(['convenioId', 'clausulas', 'clausulas_acumuladas']);
    }

    // Abre el modal de edición de archivos
    public function openEditArchivosModal($convenioId)
    {
        $this->convenioIdEditArchivos = $convenioId;
        $convenio = Convenio::with('documentos')->findOrFail($convenioId);
        $this->archivos_guardados = $convenio->documentos->toArray();
        $this->clausulas = [];
        $this->clausulas_acumuladas = [];
        $this->modalEditArchivosOpen = true;
    }

    // Guarda los nuevos archivos subidos
    public function guardarNuevosArchivos()
    {
        if ($this->clausulas_acumuladas && is_array($this->clausulas_acumuladas)) {
            foreach ($this->clausulas_acumuladas as $archivo) {
                $mime = $archivo->getClientMimeType();
                if (str_contains($mime, 'pdf')) {
                    $tipo = 'PDF';
                } elseif (str_contains($mime, 'image')) {
                    $tipo = 'Imagen';
                } else {
                    $tipo = 'Otro';
                }
                $path = $archivo->store('clausulas');
                DocumentoConvenio::create([
                    'nombreArchivo'   => $archivo->getClientOriginalName(),
                    'tipo_documento'  => $tipo,
                    'fecha_subida'    => now()->toDateString(),
                    'hora_subida'     => now()->toTimeString(),
                    'convenio_id'     => $this->convenioIdEditArchivos,
                    'ruta'            => $path,
                ]);
            }
        }
        $this->cerrarModalEditArchivos();
    }

    // Elimina un archivo guardado
    public function eliminarArchivoGuardado($id)
    {
        $doc = DocumentoConvenio::find($id);
        if ($doc) {
            Storage::delete($doc->ruta);
            $doc->delete();
        }
        // Refresca la lista
        $this->archivos_guardados = Convenio::with('documentos')->find($this->convenioIdEditArchivos)->documentos->toArray();
    }

    // Cierra el modal de edición de archivos
    public function cerrarModalEditArchivos()
    {
        $this->modalEditArchivosOpen = false;
        $this->clausulas = [];
        $this->clausulas_acumuladas = [];
        $this->archivos_guardados = [];
        $this->convenioIdEditArchivos = null;
    }
}