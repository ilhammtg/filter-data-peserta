<?php

use App\Exports\TeamsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
Route::post('/teams/import', [TeamController::class, 'import'])->name('teams.import');
Route::delete('/teams/reset', [TeamController::class, 'reset'])->name('teams.reset');
Route::get('/teams/export', function () {
    return Excel::download(new TeamsExport, 'data_tim_debat.xlsx');
})->name('teams.export');
