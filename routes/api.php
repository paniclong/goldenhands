<?php

use App\Http\Controllers\V1\ProductController;
use App\Modules\Auth\Http\Controllers\V1\LoginController;
use App\Modules\Auth\Http\Controllers\V1\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('V1')->prefix('v1')->group(static function () {
    Route::group(['prefix' => 'users'], static function () {
        Route::get('/', static function () {
            return response('Список всех пользователей');
        });

        Route::get('/{id}', static function () {
            return response('Получить пользователя по id');
        });

        Route::post('/', static function () {
            return response('Создать нового пользователя');
        });

        Route::patch('/', static function () {
            return response('Изменить параметры пользователя');
        });

        Route::delete('/', static function () {
            return response('Удалить пользователя');
        });
    });

    Route::middleware(['auth.jwt'])
        ->prefix('products')
        ->group(
            static function () {
                Route::get('/', [ProductController::class, 'list']);
                Route::get('/{product_id}', [ProductController::class, 'getById']);
            }
        );

    Route::namespace('Modules\Auth')
        ->prefix('auth')
        ->group(
            static function () {
                Route::get('/me', [LoginController::class, 'me']);
                Route::post('/register', [RegisterController::class, 'register']);
                Route::post('/login', [LoginController::class, 'loginByEmailAndPassword']);
                Route::get('/refresh', [LoginController::class, 'refreshToken']);
            }
        );
});
