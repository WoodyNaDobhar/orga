<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDueRequest;
use App\Http\Requests\UpdateDueRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DueRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class DueController extends AppBaseController
{
    /** @var DueRepository $dueRepository*/
    private $dueRepository;

    public function __construct(DueRepository $dueRepo)
    {
        $this->dueRepository = $dueRepo;
    }

    /**
     * Display a listing of the Due.
     */
    public function index(Request $request)
    {
        return view('dues.index');
    }

    /**
     * Show the form for creating a new Due.
     */
    public function create()
    {
        return view('dues.create');
    }

    /**
     * Store a newly created Due in storage.
     */
    public function store(CreateDueRequest $request)
    {
        $input = $request->all();

        $due = $this->dueRepository->create($input);

        Flash::success('Due saved successfully.');

        return redirect(route('dues.index'));
    }

    /**
     * Display the specified Due.
     */
    public function show($id)
    {
        $due = $this->dueRepository->find($id);

        if (empty($due)) {
            Flash::error('Due not found');

            return redirect(route('dues.index'));
        }

        return view('dues.show')->with('due', $due);
    }

    /**
     * Show the form for editing the specified Due.
     */
    public function edit($id)
    {
        $due = $this->dueRepository->find($id);

        if (empty($due)) {
            Flash::error('Due not found');

            return redirect(route('dues.index'));
        }

        return view('dues.edit')->with('due', $due);
    }

    /**
     * Update the specified Due in storage.
     */
    public function update($id, UpdateDueRequest $request)
    {
        $due = $this->dueRepository->find($id);

        if (empty($due)) {
            Flash::error('Due not found');

            return redirect(route('dues.index'));
        }

        $due = $this->dueRepository->update($request->all(), $id);

        Flash::success('Due updated successfully.');

        return redirect(route('dues.index'));
    }

    /**
     * Remove the specified Due from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $due = $this->dueRepository->find($id);

        if (empty($due)) {
            Flash::error('Due not found');

            return redirect(route('dues.index'));
        }

        $this->dueRepository->delete($id);

        Flash::success('Due deleted successfully.');

        return redirect(route('dues.index'));
    }
}
