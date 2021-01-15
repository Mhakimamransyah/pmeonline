<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auto-score')->group(function () {

    Route::prefix('result')->group(function () {

        Route::post('', 'AutoScoreController@result')->name('auto-score.result');

    });

});

Route::prefix('packages')->group(function () {

    Route::get('{package}', function (\App\v3\Package $package, Request $request) {

        $data = $package->load('orders', 'orders.submit')
            ->orders()
            ->get()
            ->filter(function (\App\v3\Order $order) {
                return $order->submit()->count() != 0;
            })
            ->map(function (\App\v3\Order $order) {
                return [
                    'order_id' => $order->id,
                    'submit' => $order->submit->value
                ];
            });

        if ($request->has('jsonify')) {
            $data = $data->map(function ($result) {
                return [
                    'order_id' => $result['order_id'],
                    'submit' => json_decode($result['submit']),
                ];
            });
            if ($request->has('adapt')) {
                $data = $data->map(function ($result) use ($package) {
                    $adapter = new \App\LittleFlower\SubmitAdapter();
                    return $adapter->adapt($package, $result['submit'], $result['order_id']);
                });
            }
            if ($request->has('errors')) {
                $data = $data->filter(function ($result) {
                    return $result['submit'] == null &&
                        \App\v3\Submit::query()->where('order_id', '=', $result['order_id'])->get()->first()->value != null;
                })->values();
                if ($request->has('map-order-id')) {
                    $data = $data->map(function ($result) {
                        return $result['order_id'];
                    });
                    if ($request->has('no-json')) {
                        $data = implode(',', $data->toArray());
                    }
                }
            }
        }

        return $data;

    });

    Route::get('', function (Request $request) {

        $data = \App\v3\Package::all()->load('orders', 'orders.submit')
            ->flatMap(function (\App\v3\Package $package) {
                return $package->orders;
            })
            ->filter(function (\App\v3\Order $order) {
                return $order->submit()->count() != 0;
            })
            ->map(function (\App\v3\Order $order) {
                return [
                    'order_id' => $order->id,
                    'submit' => $order->submit->value
                ];
            });

        if ($request->has('jsonify')) {
            $data = $data->map(function ($result) {
                return [
                    'order_id' => $result['order_id'],
                    'submit' => json_decode($result['submit']),
                ];
            });
            if ($request->has('errors')) {
                $data = $data->filter(function ($result) {
                    return $result['submit'] == null &&
                        \App\v3\Submit::query()->where('order_id', '=', $result['order_id'])->get()->first()->value != null;
                })->values();
                if ($request->has('map-order-id')) {
                    $data = $data->map(function ($result) {
                        return $result['order_id'];
                    });
                    if ($request->has('no-json')) {
                        $data = implode(',', $data->toArray());
                    }
                }
            }
        }

        return $data;

    });

});
