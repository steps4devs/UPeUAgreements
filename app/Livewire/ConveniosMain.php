<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Convenio;
use Illuminate\Support\Facades\Auth;

class ConveniosMain extends Component
{
    public $search = '';
    public $perPage = 10;
    public $modalOpen = false;
    public $editing = false;
    public $convenioId;
    public $nombreConvenio, $descripcion, $fecha_inicio, $fecha_fin, $estado, $alcance, $convenio_id_entidad, $facultad_id, $carrera_id;

    public $entidades = [];
    public $facultades = [];
    public $carreras = [];

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
        $this->resetValidation();
        $this->reset([
            'nombreConvenio', 'descripcion', 'fecha_inicio', 'fecha_fin', 'estado', 'alcance',
            'convenio_id_entidad', 'facultad_id', 'carrera_id', 'convenioId'
        ]);
        $this->modalOpen = true;
        $this->editing = false;

        if ($id) {
            $convenio = Convenio::findOrFail($id);
            $this->convenioId = $convenio->id;
            $this->nombreConvenio = $convenio->nombreConvenio;
            $this->descripcion = $convenio->descripcion;
            $this->fecha_inicio = $convenio->fecha_inicio;
            $this->fecha_fin = $convenio->fecha_fin;
            $this->estado = $convenio->estado;
            $this->alcance = $convenio->alcance;
            $this->convenio_id_entidad = $convenio->convenio_id_entidad;
            $this->facultad_id = $convenio->facultad_id;
            $this->carrera_id = $convenio->carrera_id;
            $this->editing = true;
        }
    }

    public function save()
    {
        $this->validate();

        // Calcular estado
        $estado = null;
        if ($this->fecha_fin) {
            $hoy = now()->startOfDay();
            $fin = \Carbon\Carbon::parse($this->fecha_fin)->startOfDay();
            $dias = $hoy->diffInDays($fin, false);

            if ($fin->lt($hoy)) {
                $estado = 'Vencido';
            } elseif ($dias <= 15) {
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

        $this->modalOpen = false;
        $this->editing = false;
        $this->reset(['convenioId']);
    }

    public function delete($id)
    {
        Convenio::findOrFail($id)->delete();
    }

    // Opcional: para el botón de detalles
    public function showDetails($id)
    {
        // Aquí puedes abrir otro modal o redirigir a una vista de detalles
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
}