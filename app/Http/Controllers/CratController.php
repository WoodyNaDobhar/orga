<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCratRequest;
use App\Http\Requests\UpdateCratRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CratRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class CratController extends AppBaseController
{
    /** @var CratRepository $cratRepository*/
    private $cratRepository;

    public function __construct(CratRepository $cratRepo)
    {
        $this->cratRepository = $cratRepo;
    }

    /**
     * Display a listing of the Crat.
     */
    public function index(Request $request)
    {
        return view('crats.index');
    }

    /**
     * Show the form for creating a new Crat.
     */
    public function create()
    {
        return view('crats.create');
    }

    /**
     * Store a newly created Crat in storage.
     */
    public function store(CreateCratRequest $request)
    {
        $input = $request->all();

        $crat = $this->cratRepository->create($input);

        Flash::success('Crat saved successfully.');

        return redirect(route('crats.index'));
    }

    /**
     * Display the specified Crat.
     */
    public function show($id)
    {
        $crat = $this->cratRepository->find($id);

        if (empty($crat)) {
            Flash::error('Crat not found');

            return redirect(route('crats.index'));
        }

        return view('crats.show')->with('crat', $crat);
    }

    /**
     * Show the form for editing the specified Crat.
     */
    public function edit($id)
    {
        $crat = $this->cratRepository->find($id);

        if (empty($crat)) {
            Flash::error('Crat not found');

            return redirect(route('crats.index'));
        }

        return view('crats.edit')->with('crat', $crat);
    }

    /**
     * Update the specified Crat in storage.
     */
    public function update($id, UpdateCratRequest $request)
    {
        $crat = $this->cratRepository->find($id);

        if (empty($crat)) {
            Flash::error('Crat not found');

            return redirect(route('crats.index'));
        }

        $crat = $this->cratRepository->update($request->all(), $id);

        Flash::success('Crat updated successfully.');

        return redirect(route('crats.index'));
    }

    /**
     * Remove the specified Crat from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $crat = $this->cratRepository->find($id);

        if (empty($crat)) {
            Flash::error('Crat not found');

            return redirect(route('crats.index'));
        }

        $this->cratRepository->delete($id);

        Flash::success('Crat deleted successfully.');

        return redirect(route('crats.index'));
    }
}
