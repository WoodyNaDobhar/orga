<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKingdomRequest;
use App\Http\Requests\UpdateKingdomRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\KingdomRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class KingdomController extends AppBaseController
{
    /** @var KingdomRepository $kingdomRepository*/
    private $kingdomRepository;

    public function __construct(KingdomRepository $kingdomRepo)
    {
        $this->kingdomRepository = $kingdomRepo;
    }

    /**
     * Display a listing of the Realm.
     */
    public function index(Request $request)
    {
        return view('kingdoms.index');
    }

    /**
     * Show the form for creating a new Realm.
     */
    public function create()
    {
        return view('kingdoms.create');
    }

    /**
     * Store a newly created Realm in storage.
     */
    public function store(CreateKingdomRequest $request)
    {
        $input = $request->all();

        $realm = $this->kingdomRepository->create($input);

        Flash::success('Realm saved successfully.');

        return redirect(route('kingdoms.index'));
    }

    /**
     * Display the specified Realm.
     */
    public function show($id)
    {
        $realm = $this->kingdomRepository->find($id);

        if (empty($realm)) {
            Flash::error('Realm not found');

            return redirect(route('kingdoms.index'));
        }

        return view('kingdoms.show')->with('realm', $realm);
    }

    /**
     * Show the form for editing the specified Realm.
     */
    public function edit($id)
    {
        $realm = $this->kingdomRepository->find($id);

        if (empty($realm)) {
            Flash::error('Realm not found');

            return redirect(route('kingdoms.index'));
        }

        return view('kingdoms.edit')->with('realm', $realm);
    }

    /**
     * Update the specified Realm in storage.
     */
    public function update($id, UpdateKingdomRequest $request)
    {
        $realm = $this->kingdomRepository->find($id);

        if (empty($realm)) {
            Flash::error('Realm not found');

            return redirect(route('kingdoms.index'));
        }

        $realm = $this->kingdomRepository->update($request->all(), $id);

        Flash::success('Realm updated successfully.');

        return redirect(route('kingdoms.index'));
    }

    /**
     * Remove the specified Realm from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $realm = $this->kingdomRepository->find($id);

        if (empty($realm)) {
            Flash::error('Realm not found');

            return redirect(route('kingdoms.index'));
        }

        $this->kingdomRepository->delete($id);

        Flash::success('Realm deleted successfully.');

        return redirect(route('kingdoms.index'));
    }
}
