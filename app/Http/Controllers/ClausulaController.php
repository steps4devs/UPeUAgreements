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
}
