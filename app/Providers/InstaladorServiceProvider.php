<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class InstaladorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Verificar si ya se han generado las claves de la aplicación
        if (env('APP_KEY') === null) {
            Artisan::call('key:generate');
        }
        // Verificar si las migraciones aún no se han ejecutado
        if (!$this->migrationsHaveRun()) {
            Artisan::call('migrate');
            // Marcar que las migraciones han sido ejecutadas en el archivo .env
            $this->markMigrationsAsRun();
        }
        if (!$this->seedersHaveRun()) {
            $this->runSeeders();
            // Marcar que los seeders han sido ejecutados en el archivo .env
            $this->markSeedersAsRun();
        }
        // Ejecutar composer install
        $this->composerInstall();

        // Ejecutar npm install
        $this->npmInstall();

        // Establecer el nombre de la base de datos en el archivo .env
        $this->setDatabaseName();
    }

    public function register()
    {
        // Copiar .env.example a .env si .env no existe
        if (!File::exists(base_path('.env'))) {
            File::copy('.env.example', '.env');
            $this->output("Copiando '.env.example' a '.env'");
        }
    }

    /**
     * Verificar si las migraciones ya se han ejecutado.
     *
     * @return bool
     */
    protected function migrationsHaveRun()
    {
        return env('MIGRATIONS_HAVE_RUN', false);
    }

    /**
     * Marcar que las migraciones ya se han ejecutado en el archivo .env.
     *
     * @return void
     */
    protected function markMigrationsAsRun()
    {
        file_put_contents(base_path('.env'), PHP_EOL . 'MIGRATIONS_HAVE_RUN=true', FILE_APPEND);
    }

    /**
     * Ejecutar `composer install`.
     *
     * @return void
     */
    protected function composerInstall()
    {
        if (!file_exists(base_path('vendor/autoload.php'))) {
            $this->output("Ejecutando 'composer install'");
            Artisan::call('composer install');
        }
    }

    /**
     * Ejecutar `npm install`.
     *
     * @return void
     */
    protected function npmInstall()
    {
        if (!file_exists(base_path('node_modules'))) {
            $this->output("Ejecutando 'npm install'");
            Artisan::call('npm install');
        }
    }
    /**
     * Verificar si los seeders ya se han ejecutado.
     *
     * @return bool
     */
    protected function seedersHaveRun()
    {
        return env('SEEDERS_HAVE_RUN', false);
    }

    /**
     * Ejecutar los seeders.
     *
     * @return void
     */
    protected function runSeeders()
    {
        Artisan::call('db:seed');
    }

    /**
     * Marcar que los seeders ya se han ejecutado en el archivo .env.
     *
     * @return void
     */
    protected function markSeedersAsRun()
    {
        file_put_contents(base_path('.env'), PHP_EOL . 'SEEDERS_HAVE_RUN=true', FILE_APPEND);
    }

    protected function setDatabaseName()
    {
        $envFilePath = base_path('.env');

        // Obtener el nombre de la base de datos (puedes ajustar esto según tus necesidades)
        $databaseName = 'db_fodap';

        // Abrir el archivo .env para lectura/escritura
        $content = file_get_contents($envFilePath);

        // Reemplazar o agregar la línea que establece el nombre de la base de datos
        $content = preg_replace('/DB_DATABASE=.*$/m', 'DB_DATABASE=' . $databaseName, $content);

        // Guardar los cambios en el archivo .env
        file_put_contents($envFilePath, $content);
    }

    /**
     * Mostrar salida en la consola (opcional).
     *
     * @param  string  $message
     * @return void
     */
    protected function output($message)
    {
        $this->app->runningInConsole() ? $this->line($message) : null;
    }
}
