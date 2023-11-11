<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReignRequest;
use App\Http\Requests\UpdateReignRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReignRepository;
use Illuminate\Http\Request;
use Flash;

class ReignController extends AppBaseController
{
    /** @var ReignRepository $reignRepository*/
    private $reignRepository;

    public function __construct(ReignRepository $reignRepo)
    {
        $this->reignRepository = $reignRepo;
    }

    /**
     * Display a listing of the Reign.
     */
    public function index(Request $request)
    {
        return view('reigns.index');
    }

    /**
     * Show the form for creating a new Reign.
     */
    public function create()
    {
        return view('reigns.create');
    }

    /**
     * Store a newly created Reign in storage.
     */
    public function store(CreateReignRequest $request)
    {
        $input = $request->all();

        $reign = $this->reignRepository->create($input);

        Flash::success('Reign saved successfully.');

        return redirect(route('reigns.index'));
    }

    /**
     * Display the specified Reign.
     */
    public function show($id)
    {
        $reign = $this->reignRepository->find($id);

        if (empty($reign)) {
            Flash::error('Reign not found');

            return redirect(route('reigns.index'));
        }

        return view('reigns.show')->with('reign', $reign);
    }

    /**
     * Show the form for editing the specified Reign.
     */
    public function edit($id)
    {
        $reign = $this->reignRepository->find($id);

        if (empty($reign)) {
            Flash::error('Reign not found');

            return redirect(route('reigns.index'));
        }

        return view('reigns.edit')->with('reign', $reign);
    }

    /**
     * Update the specified Reign in storage.
     */
    public function update($id, UpdateReignRequest $request)
    {
        $reign = $this->reignRepository->find($id);

        if (empty($reign)) {
            Flash::error('Reign not found');

            return redirect(route('reigns.index'));
        }

        $reign = $this->reignRepository->update($request->all(), $id);

        Flash::success('Reign updated successfully.');

        return redirect(route('reigns.index'));
    }

    /**
     * Remove the specified Reign from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $reign = $this->reignRepository->find($id);

        if (empty($reign)) {
            Flash::error('Reign not found');

            return redirect(route('reigns.index'));
        }

        $this->reignRepository->delete($id);

        Flash::success('Reign deleted successfully.');

        return redirect(route('reigns.index'));
    }
}
