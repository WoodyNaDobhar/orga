<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKingdomRequest;
use App\Http\Requests\UpdateKingdomRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\KingdomRepository;
use Illuminate\Http\Request;
use Flash;

class KingdomController extends AppBaseController
{
    /** @var KingdomRepository $kingdomRepository*/
    private $kingdomRepository;

    public function __construct(KingdomRepository $kingdomRepo)
    {
        $this->kingdomRepository = $kingdomRepo;
    }

    /**
     * Display a listing of the Kingdom.
     */
    public function index(Request $request)
    {
        return view('kingdoms.index');
    }

    /**
     * Show the form for creating a new Kingdom.
     */
    public function create()
    {
        return view('kingdoms.create');
    }

    /**
     * Store a newly created Kingdom in storage.
     */
    public function store(CreateKingdomRequest $request)
    {
        $input = $request->all();

        $kingdom = $this->kingdomRepository->create($input);

        Flash::success('Kingdom saved successfully.');

        return redirect(route('kingdoms.index'));
    }

    /**
     * Display the specified Kingdom.
     */
    public function show($id)
    {
        $kingdom = $this->kingdomRepository->find($id);

        if (empty($kingdom)) {
            Flash::error('Kingdom not found');

            return redirect(route('kingdoms.index'));
        }

        return view('kingdoms.show')->with('kingdom', $kingdom);
    }

    /**
     * Show the form for editing the specified Kingdom.
     */
    public function edit($id)
    {
        $kingdom = $this->kingdomRepository->find($id);

        if (empty($kingdom)) {
            Flash::error('Kingdom not found');

            return redirect(route('kingdoms.index'));
        }

        return view('kingdoms.edit')->with('kingdom', $kingdom);
    }

    /**
     * Update the specified Kingdom in storage.
     */
    public function update($id, UpdateKingdomRequest $request)
    {
        $kingdom = $this->kingdomRepository->find($id);

        if (empty($kingdom)) {
            Flash::error('Kingdom not found');

            return redirect(route('kingdoms.index'));
        }

        $kingdom = $this->kingdomRepository->update($request->all(), $id);

        Flash::success('Kingdom updated successfully.');

        return redirect(route('kingdoms.index'));
    }

    /**
     * Remove the specified Kingdom from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $kingdom = $this->kingdomRepository->find($id);

        if (empty($kingdom)) {
            Flash::error('Kingdom not found');

            return redirect(route('kingdoms.index'));
        }

        $this->kingdomRepository->delete($id);

        Flash::success('Kingdom deleted successfully.');

        return redirect(route('kingdoms.index'));
    }
}
