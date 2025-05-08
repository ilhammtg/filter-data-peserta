<?php

namespace App\Http\Controllers;

use App\Exports\TeamsExport;
use App\Imports\TeamsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Team;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = Team::with(['debaters']);

        // Filter by team name
        if ($request->filled('team_name')) {
            $query->where('name', 'like', '%' . $request->team_name . '%');
        }

        // Filter by debater name
        if ($request->filled('debater_name')) {
            $query->whereHas('debaters', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->debater_name . '%');
            });
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_validated', $request->payment_status);
        }

        // Filter by study program
        if ($request->filled('study_program')) {
            $query->whereHas('debaters', function ($q) use ($request) {
                $q->where('study_program', 'like', '%' . $request->study_program . '%');
            });
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        // Pagination with query string
        $teams = $query->paginate(10)
            ->withQueryString();

        return view('teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $team->load('debaters');
        return view('teams.show', compact('team'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            Excel::import(new TeamsImport, $request->file('file'));

            return back()->with('success', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function reset()
    {
        DB::statement('DROP TABLE IF EXISTS debaters, teams');
        // Jalankan migrasi ulang
        Artisan::call('migrate:fresh --seed');

        return redirect()->route('teams.index')
            ->with('success', 'Database berhasil direset ulang!');
    }

    public function export(Request $request)
    {
        $query = Team::with(['debaters']);

        if ($request->has('team_name')) {
            $query->where('name', 'like', '%' . $request->team_name . '%');
        }

        $teams = $query->get();

        return Excel::download(new TeamsExport($teams), 'data_tim_debat.xlsx');
    }
}
