<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TournamentRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class TournamentController extends AppBaseController
{
    /** @var TournamentRepository $tournamentRepository*/
    private $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepo)
    {
        $this->tournamentRepository = $tournamentRepo;
    }

    /**
     * Display a listing of the Tournament.
     */
    public function index(Request $request)
    {
        return view('tournaments.index');
    }

    /**
     * Show the form for creating a new Tournament.
     */
    public function create()
    {
        return view('tournaments.create');
    }

    /**
     * Store a newly created Tournament in storage.
     */
    public function store(CreateTournamentRequest $request)
    {
        $input = $request->all();

        $tournament = $this->tournamentRepository->create($input);

        Flash::success('Tournament saved successfully.');

        return redirect(route('tournaments.index'));
    }

    /**
     * Display the specified Tournament.
     */
    public function show($id)
    {
        $tournament = $this->tournamentRepository->find($id);

        if (empty($tournament)) {
            Flash::error('Tournament not found');

            return redirect(route('tournaments.index'));
        }

        return view('tournaments.show')->with('tournament', $tournament);
    }

    /**
     * Show the form for editing the specified Tournament.
     */
    public function edit($id)
    {
        $tournament = $this->tournamentRepository->find($id);

        if (empty($tournament)) {
            Flash::error('Tournament not found');

            return redirect(route('tournaments.index'));
        }

        return view('tournaments.edit')->with('tournament', $tournament);
    }

    /**
     * Update the specified Tournament in storage.
     */
    public function update($id, UpdateTournamentRequest $request)
    {
        $tournament = $this->tournamentRepository->find($id);

        if (empty($tournament)) {
            Flash::error('Tournament not found');

            return redirect(route('tournaments.index'));
        }

        $tournament = $this->tournamentRepository->update($request->all(), $id);

        Flash::success('Tournament updated successfully.');

        return redirect(route('tournaments.index'));
    }

    /**
     * Remove the specified Tournament from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tournament = $this->tournamentRepository->find($id);

        if (empty($tournament)) {
            Flash::error('Tournament not found');

            return redirect(route('tournaments.index'));
        }

        $this->tournamentRepository->delete($id);

        Flash::success('Tournament deleted successfully.');

        return redirect(route('tournaments.index'));
    }
}
