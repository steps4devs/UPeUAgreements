<?php

namespace App\Livewire;

use App\Models\Convenio;
use App\Models\Entidad;
use App\Models\Facultad;
use App\Models\Carrera;
use Livewire\Component;

class ConveniosMain extends Component
{
    public $action = '';
    public $convenios = [];
    public $entidades = [];
    public $facultades = [];
    public $carreras = [];

    // Campos del formulario
    public $nombreConvenio, $entidad_id, $descripcion, $fecha_inicio, $fecha_fin, $estado, $alcance, $facultad_id, $carrera_id;
    public $convenioGuardado = false;
    public $editando = false;
    public $convenio_id_edit = null;

    // Para el combobox de entidad
    public $entidad_search = '';
    public $entidad_suggestions = [];
    public $showEntidadForm = false;
    public $nuevaEntidad = [
        'nombreEntidad' => '',
        'logo' => '',
        'ubicacion' => '',
        'contacto' => '',
    ];

    public function mount()
    {
        $this->action = request('action', '');
        $this->entidades = Entidad::all();
        $this->facultades = Facultad::all();
        $this->carreras = Carrera::all();
        $this->convenios = Convenio::with(['entidad', 'facultad', 'carrera'])->get();
    }

    public function guardarConvenio()
    {
        $this->validate([
            'nombreConvenio' => 'required|string|max:255',
            'entidad_id' => 'required|exists:entidads,id',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:Vigente,Vencido,Por vencer',
            'alcance' => 'required|in:Carrera,Facultad,Universidad',
            'facultad_id' => 'required|exists:facultads,id',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        Convenio::create([
            'nombreConvenio' => $this->nombreConvenio,
            'convenio_id_entidad' => $this->entidad_id,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'estado' => $this->estado,
            'alcance' => $this->alcance,
            'convenio_creador' => auth()->id(),
            'facultad_id' => $this->facultad_id,
            'carrera_id' => $this->carrera_id,
        ]);

        $this->convenioGuardado = true;
        session()->flash('success', 'Convenio creado correctamente.');
        return redirect()->route('convenios-main');
    }

    public function editar($id)
    {
        $convenio = Convenio::findOrFail($id);

        $this->convenio_id_edit = $convenio->id;
        $this->nombreConvenio = $convenio->nombreConvenio;
        $this->entidad_id = $convenio->convenio_id_entidad;
        $this->entidad_search = $convenio->entidad->nombreEntidad ?? '';
        $this->descripcion = $convenio->descripcion;
        $this->fecha_inicio = $convenio->fecha_inicio;
        $this->fecha_fin = $convenio->fecha_fin;
        $this->estado = $convenio->estado;
        $this->alcance = $convenio->alcance;
        $this->facultad_id = $convenio->facultad_id;
        $this->carrera_id = $convenio->carrera_id;

        $this->action = 'edit';
        $this->editando = true;
    }

    public function actualizarConvenio()
    {
        $this->validate([
            'nombreConvenio' => 'required|string|max:255',
            'entidad_id' => 'required|exists:entidads,id',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:Vigente,Vencido,Por vencer',
            'alcance' => 'required|in:Carrera,Facultad,Universidad',
            'facultad_id' => 'required|exists:facultads,id',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        $convenio = Convenio::findOrFail($this->convenio_id_edit);
        $convenio->update([
            'nombreConvenio' => $this->nombreConvenio,
            'convenio_id_entidad' => $this->entidad_id,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'estado' => $this->estado,
            'alcance' => $this->alcance,
            'facultad_id' => $this->facultad_id,
            'carrera_id' => $this->carrera_id,
        ]);

        session()->flash('success', 'Convenio actualizado correctamente.');
        return redirect()->route('convenios-main');
    }

    public function eliminar($id)
    {
        $convenio = Convenio::findOrFail($id);
        $convenio->delete();

        session()->flash('success', 'Convenio eliminado correctamente.');
        return redirect()->route('convenios-main');
    }

    public function cancelar()
    {
        return redirect()->route('convenios-main');
    }

    // --- Combobox de entidad ---
    public function updatedEntidadSearch($value)
    {
        // Busca entidades que contengan el texto escrito
        $this->entidad_suggestions = Entidad::where('nombreEntidad', 'like', '%' . $value . '%')->get();
        // Si el texto no coincide con ninguna entidad, resetea el id
        $this->entidad_id = null;
        $this->showEntidadForm = false;
    }

    public function seleccionarEntidad($id)
    {
        $entidad = Entidad::find($id);
        $this->entidad_id = $entidad->id;
        $this->entidad_search = $entidad->nombreEntidad;
        $this->entidad_suggestions = [];
        $this->showEntidadForm = false;
    }

    public function crearNuevaEntidad()
    {
        $this->showEntidadForm = true;
    }

    public function guardarEntidad()
    {
        $entidad = Entidad::create($this->nuevaEntidad);
        $this->entidad_id = $entidad->id;
        $this->entidad_search = $entidad->nombreEntidad;
        $this->showEntidadForm = false;
        $this->entidad_suggestions = [];
        $this->nuevaEntidad = ['nombreEntidad' => '', 'logo' => '', 'ubicacion' => '', 'contacto' => ''];
    }

    public function render()
    {
        return view('livewire.convenios-main');
    }
}