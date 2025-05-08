<?php

namespace App\Exports;

use App\Models\Team;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TeamsExport implements FromView
{
    protected $teams;

    public function __construct($teams)
    {
        $this->teams = $teams;
    }

    public function view(): View
    {
        return view('exports.teams', [
            'teams' => $this->teams
        ]);
    }
}
