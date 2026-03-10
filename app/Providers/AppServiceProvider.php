<?php

namespace App\Providers;

use App\Models\Activo;
use App\Policies\ActivoPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Policies\EmpresaPolicy;
use App\Models\Empresa;
use App\Models\User;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
   public function boot(): void
{
    Gate::policy(Activo::class, ActivoPolicy::class);
    Gate::policy(Empresa::class, EmpresaPolicy::class);
    Gate::policy(User::class,     UserPolicy::class);
}
}