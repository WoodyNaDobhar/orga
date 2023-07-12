<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePronounRequest;
use App\Http\Requests\UpdatePronounRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PronounRepository;
use Illuminate\Http\Request;
use Flash;

class PronounController extends AppBaseController
{
    /** @var PronounRepository $pronounRepository*/
    private $pronounRepository;

    public function __construct(PronounRepository $pronounRepo)
    {
        $this->pronounRepository = $pronounRepo;
    }

    /**
     * Display a listing of the Pronoun.
     */
    public function index(Request $request)
    {
        return view('pronouns.index');
    }

    /**
     * Show the form for creating a new Pronoun.
     */
    public function create()
    {
        return view('pronouns.create');
    }

    /**
     * Store a newly created Pronoun in storage.
     */
    public function store(CreatePronounRequest $request)
    {
        $input = $request->all();

        $pronoun = $this->pronounRepository->create($input);

        Flash::success('Pronoun saved successfully.');

        return redirect(route('pronouns.index'));
    }

    /**
     * Display the specified Pronoun.
     */
    public function show($id)
    {
        $pronoun = $this->pronounRepository->find($id);

        if (empty($pronoun)) {
            Flash::error('Pronoun not found');

            return redirect(route('pronouns.index'));
        }

        return view('pronouns.show')->with('pronoun', $pronoun);
    }

    /**
     * Show the form for editing the specified Pronoun.
     */
    public function edit($id)
    {
        $pronoun = $this->pronounRepository->find($id);

        if (empty($pronoun)) {
            Flash::error('Pronoun not found');

            return redirect(route('pronouns.index'));
        }

        return view('pronouns.edit')->with('pronoun', $pronoun);
    }

    /**
     * Update the specified Pronoun in storage.
     */
    public function update($id, UpdatePronounRequest $request)
    {
        $pronoun = $this->pronounRepository->find($id);

        if (empty($pronoun)) {
            Flash::error('Pronoun not found');

            return redirect(route('pronouns.index'));
        }

        $pronoun = $this->pronounRepository->update($request->all(), $id);

        Flash::success('Pronoun updated successfully.');

        return redirect(route('pronouns.index'));
    }

    /**
     * Remove the specified Pronoun from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pronoun = $this->pronounRepository->find($id);

        if (empty($pronoun)) {
            Flash::error('Pronoun not found');

            return redirect(route('pronouns.index'));
        }

        $this->pronounRepository->delete($id);

        Flash::success('Pronoun deleted successfully.');

        return redirect(route('pronouns.index'));
    }
}
