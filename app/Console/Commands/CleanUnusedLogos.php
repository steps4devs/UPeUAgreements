<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Entidad;

class CleanUnusedLogos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logos:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminar logos no asociados a ninguna entidad';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usedLogos = Entidad::pluck('logo')->toArray(); // Logos usados en la base de datos
        $allLogos = Storage::disk('public')->files('logos'); // Todos los logos en el almacenamiento

        $unusedLogos = array_diff($allLogos, $usedLogos); // Logos no utilizados

        foreach ($unusedLogos as $logo) {
            Storage::disk('public')->delete($logo); // Eliminar cada logo no utilizado
        }

        $this->info('Logos no utilizados eliminados correctamente.');
    }
}
