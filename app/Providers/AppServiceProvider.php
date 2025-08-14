<?php

namespace App\Providers;

use App\Models\User; // Asegúrate de que esta línea esté presente
use Illuminate\Support\Facades\Gate; // Asegúrate de que esta línea esté presente
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * INICIO DE LA MODIFICACIÓN: Definimos nuestro Gate de Administrador.
         *
         * Gate::define() crea una nueva regla de permiso.
         * 'esAdmin' es el nombre que le damos a nuestra regla.
         * La función recibe al usuario autenticado ($user).
         * Retorna 'true' si el rol del usuario es 'admin', de lo contrario retorna 'false'.
         * Aquí usamos la función isAdmin() que creamos en el modelo User.
         */
        Gate::define('esAdmin', function (User $user) {
            return $user->isAdmin();
        });
        /**
         * FIN DE LA MODIFICACIÓN
         */
    }
}