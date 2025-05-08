<?php

use App\Exports\TeamsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [TeamController::class, 'index'])->name('teams.index');
// Route::get('/{team}', [TeamController::class, 'show'])->name('teams.show');
Route::post('/import', [TeamController::class, 'import'])->name('teams.import');
Route::delete('/reset', [TeamController::class, 'reset'])->name('teams.reset');
Route::get('/export', [TeamController::class, 'export'])->name('teams.export');

Route::get('/test-route', function () {
    return 'Test route is working!';
});
