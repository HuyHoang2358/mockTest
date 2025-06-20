<?php
namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Session\DatabaseSessionHandler;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Session::extend('morph_database', function ($app) {
            return new class(
                $app['db']->connection(),
                $app['config']['session.table'],
                $app['config']['session.lifetime']
            ) extends DatabaseSessionHandler {
                protected function addUserInformation(&$payload): void
                {
                    if (Auth::guard('admin')->check()) {
                        $payload['authenticatable_id'] = Auth::guard('admin')->id();
                        $payload['authenticatable_type'] = get_class(Auth::guard('admin')->user());
                    } elseif (Auth::check()) {
                        $payload['authenticatable_id'] = Auth::id();
                        $payload['authenticatable_type'] = get_class(Auth::user());
                    }
                }

                public function write($sessionId, $data): bool
                {
                    $payload = $this->getDefaultPayload($data);
                    $this->addUserInformation($payload);
                    return parent::write($sessionId, serialize($payload));
                }
            };
        });
    }
}
