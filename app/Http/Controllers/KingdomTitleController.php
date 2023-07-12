<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKingdomTitleRequest;
use App\Http\Requests\UpdateKingdomTitleRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\KingdomTitleRepository;
use Illuminate\Http\Request;
use Flash;

class KingdomTitleController extends AppBaseController
{
    /** @var KingdomTitleRepository $kingdomTitleRepository*/
    private $kingdomTitleRepository;

    public function __construct(KingdomTitleRepository $kingdomTitleRepo)
    {
        $this->kingdomTitleRepository = $kingdomTitleRepo;
    }

    /**
     * Display a listing of the KingdomTitle.
     */
    public function index(Request $request)
    {
        return view('kingdom_titles.index');
    }

    /**
     * Show the form for creating a new KingdomTitle.
     */
    public function create()
    {
        return view('kingdom_titles.create');
    }

    /**
     * Store a newly created KingdomTitle in storage.
     */
    public function store(CreateKingdomTitleRequest $request)
    {
        $input = $request->all();

        $kingdomTitle = $this->kingdomTitleRepository->create($input);

        Flash::success('Kingdom Title saved successfully.');

        return redirect(route('kingdomTitles.index'));
    }

    /**
     * Display the specified KingdomTitle.
     */
    public function show($id)
    {
        $kingdomTitle = $this->kingdomTitleRepository->find($id);

        if (empty($kingdomTitle)) {
            Flash::error('Kingdom Title not found');

            return redirect(route('kingdomTitles.index'));
        }

        return view('kingdom_titles.show')->with('kingdomTitle', $kingdomTitle);
    }

    /**
     * Show the form for editing the specified KingdomTitle.
     */
    public function edit($id)
    {
        $kingdomTitle = $this->kingdomTitleRepository->find($id);

        if (empty($kingdomTitle)) {
            Flash::error('Kingdom Title not found');

            return redirect(route('kingdomTitles.index'));
        }

        return view('kingdom_titles.edit')->with('kingdomTitle', $kingdomTitle);
    }

    /**
     * Update the specified KingdomTitle in storage.
     */
    public function update($id, UpdateKingdomTitleRequest $request)
    {
        $kingdomTitle = $this->kingdomTitleRepository->find($id);

        if (empty($kingdomTitle)) {
            Flash::error('Kingdom Title not found');

            return redirect(route('kingdomTitles.index'));
        }

        $kingdomTitle = $this->kingdomTitleRepository->update($request->all(), $id);

        Flash::success('Kingdom Title updated successfully.');

        return redirect(route('kingdomTitles.index'));
    }

    /**
     * Remove the specified KingdomTitle from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $kingdomTitle = $this->kingdomTitleRepository->find($id);

        if (empty($kingdomTitle)) {
            Flash::error('Kingdom Title not found');

            return redirect(route('kingdomTitles.index'));
        }

        $this->kingdomTitleRepository->delete($id);

        Flash::success('Kingdom Title deleted successfully.');

        return redirect(route('kingdomTitles.index'));
    }
}
