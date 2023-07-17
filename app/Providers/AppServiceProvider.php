<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

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
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Response::macro('success', function ($data = [], $status = 200, array $headers = [], $options = 0) {
            $default = [
                'success' => true,
                'message' => 'Success.',
            ];

            if (is_string($data)) {
                $data = [
                    'data' => $data,
                ];
            } elseif ($data instanceof Arrayable) {
                $data = $data->toArray();
            } elseif ($data instanceof ResourceCollection) {
                $status = $data->response()->status();
                $data = $data->response()->getData(true);
            } elseif ($data instanceof JsonResource) {
                $status = $data->response()->status();
                $data = $data->response()->getData(true);
            } elseif ($data === null) {
                $data = [
                    'data' => null,
                ];
            }

            $data = array_merge($default, $data);
            return Response::json($data, $status, $headers, $options);
        });

        Response::macro('error', function ($message, $status = 500, array $headers = [], $options = 0) {
            $data = [
                'success' => false,
                'message' => $message,
            ];

            return Response::json($data, $status, $headers, $options);
        });

        Response::macro('collection', function ($data, $status = 200, array $headers = [], $options = 0) {
            $data = [
                'current_page' => $data->currentPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
                'per_page' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
                'data' => $data,
            ];

            return Response::json($data, $status, $headers, $options);
        });


        View::composer([
            'task.create',
            'task.edit'
        ], function (\Illuminate\View\View $view) {
            $users = \App\Models\User::whereNotIn('email', ['admin@gmail.com', 'manager@gmail.com'])->orderBy('name')->get();
            $view->with('users', $users);
        });
    }
}
