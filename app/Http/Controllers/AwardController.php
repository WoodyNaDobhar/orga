<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAwardRequest;
use App\Http\Requests\UpdateAwardRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AwardRepository;
use Illuminate\Http\Request;
use Flash;

class AwardController extends AppBaseController
{
    /** @var AwardRepository $awardRepository*/
    private $awardRepository;

    public function __construct(AwardRepository $awardRepo)
    {
        $this->awardRepository = $awardRepo;
    }

    /**
     * Display a listing of the Award.
     */
    public function index(Request $request)
    {
        return view('awards.index');
    }

    /**
     * Show the form for creating a new Award.
     */
    public function create()
    {
        return view('awards.create');
    }

    /**
     * Store a newly created Award in storage.
     */
    public function store(CreateAwardRequest $request)
    {
        $input = $request->all();

        $award = $this->awardRepository->create($input);

        Flash::success('Award saved successfully.');

        return redirect(route('awards.index'));
    }

    /**
     * Display the specified Award.
     */
    public function show($id)
    {
        $award = $this->awardRepository->find($id);

        if (empty($award)) {
            Flash::error('Award not found');

            return redirect(route('awards.index'));
        }

        return view('awards.show')->with('award', $award);
    }

    /**
     * Show the form for editing the specified Award.
     */
    public function edit($id)
    {
        $award = $this->awardRepository->find($id);

        if (empty($award)) {
            Flash::error('Award not found');

            return redirect(route('awards.index'));
        }

        return view('awards.edit')->with('award', $award);
    }

    /**
     * Update the specified Award in storage.
     */
    public function update($id, UpdateAwardRequest $request)
    {
        $award = $this->awardRepository->find($id);

        if (empty($award)) {
            Flash::error('Award not found');

            return redirect(route('awards.index'));
        }

        $award = $this->awardRepository->update($request->all(), $id);

        Flash::success('Award updated successfully.');

        return redirect(route('awards.index'));
    }

    /**
     * Remove the specified Award from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $award = $this->awardRepository->find($id);

        if (empty($award)) {
            Flash::error('Award not found');

            return redirect(route('awards.index'));
        }

        $this->awardRepository->delete($id);

        Flash::success('Award deleted successfully.');

        return redirect(route('awards.index'));
    }
}
