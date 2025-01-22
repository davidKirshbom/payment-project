<?php
    use App\Http\Controllers\OrderController;
    use Illuminate\Http\Request;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/orders', [OrderController::class, 'index']);

        Route::post('/orders', [OrderController::class, 'store']);
        Route::put('/orders/{id}', [OrderController::class, 'update']);
        Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
    });
    Route::get('/login', function(Request $request) {
       
        return response()->json(['message' => 'Login route is missing.'.json_encode($request->headers->all())], 404);
    })->name('login');