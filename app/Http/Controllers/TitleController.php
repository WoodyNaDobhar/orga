<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTitleRequest;
use App\Http\Requests\UpdateTitleRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TitleRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class TitleController extends AppBaseController
{
    /** @var TitleRepository $titleRepository*/
    private $titleRepository;

    public function __construct(TitleRepository $titleRepo)
    {
        $this->titleRepository = $titleRepo;
    }

    /**
     * Display a listing of the Title.
     */
    public function index(Request $request)
    {
        return view('titles.index');
    }

    /**
     * Show the form for creating a new Title.
     */
    public function create()
    {
        return view('titles.create');
    }

    /**
     * Store a newly created Title in storage.
     */
    public function store(CreateTitleRequest $request)
    {
        $input = $request->all();

        $title = $this->titleRepository->create($input);

        Flash::success('Title saved successfully.');

        return redirect(route('titles.index'));
    }

    /**
     * Display the specified Title.
     */
    public function show($id)
    {
        $title = $this->titleRepository->find($id);

        if (empty($title)) {
            Flash::error('Title not found');

            return redirect(route('titles.index'));
        }

        return view('titles.show')->with('title', $title);
    }

    /**
     * Show the form for editing the specified Title.
     */
    public function edit($id)
    {
        $title = $this->titleRepository->find($id);

        if (empty($title)) {
            Flash::error('Title not found');

            return redirect(route('titles.index'));
        }

        return view('titles.edit')->with('title', $title);
    }

    /**
     * Update the specified Title in storage.
     */
    public function update($id, UpdateTitleRequest $request)
    {
        $title = $this->titleRepository->find($id);

        if (empty($title)) {
            Flash::error('Title not found');

            return redirect(route('titles.index'));
        }

        $title = $this->titleRepository->update($request->all(), $id);

        Flash::success('Title updated successfully.');

        return redirect(route('titles.index'));
    }

    /**
     * Remove the specified Title from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $title = $this->titleRepository->find($id);

        if (empty($title)) {
            Flash::error('Title not found');

            return redirect(route('titles.index'));
        }

        $this->titleRepository->delete($id);

        Flash::success('Title deleted successfully.');

        return redirect(route('titles.index'));
    }
}
