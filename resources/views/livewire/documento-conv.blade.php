<?php
namespace App\Http\Controllers;

use App\Models\DocumentoConvenio;
use Illuminate\Support\Facades\Storage;

class ClausulaController extends Controller
{
    public function descargar($id)
    {
        $doc = DocumentoConvenio::findOrFail($id);
        return Storage::download($doc->ruta, $doc->nombreArchivo);
    }

    public function eliminar($id)
    {
        $doc = DocumentoConvenio::findOrFail($id);
        Storage::delete($doc->ruta);
        $doc->delete();
        return back()->with('success', 'Archivo eliminado');
    }
}
?>
<div>
    {{-- Do your work, then step back. --}}
</div>
