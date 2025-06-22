<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Stevebauman\Location\Facades\Location;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     * @throws \Exception
     */
    public function boot(): void
    {
        Inertia::share([
            'auth' => fn () => [
                'user' => Auth::user(),
                'role' => Auth::user()?->loadMissing('roles')->roles->first()?->name,
                'is_admin' => Auth::user()?->hasRole(RoleEnum::ADMIN->value),
                'is_client' => Auth::user()?->hasRole(RoleEnum::CLIENT->value),
                'is_moder' => Auth::user()?->hasRole(RoleEnum::MODERATOR->value),
                'is_seller' => Auth::user()?->hasRole(RoleEnum::SELLER->value),
                'is_owner' => Auth::user()?->hasRole(RoleEnum::OWNER->value),
            ],
        ]);




        Vite::prefetch(concurrency: 3);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'translations' =>  Lang::get('static'),
        ]);
    }

    private function determineLocale(): string
    {
        $ip = request()->ip();

        if ($ip === '172.18.0.1' || $ip === '127.0.0.1') {
            $ip = '146.70.52.62';
        }
        try {
            $position = Location::get($ip);
            $country = $position?->countryCode ?? null;
        } catch (\Exception $e) {
            $country = null;
        }

        return match ($country) {
            'RU', 'AM', 'KZ', 'UA', 'BY' => 'ru',
            'CN', 'HK', 'TW' => 'zh',
            default => 'en',
        };
    }
}
