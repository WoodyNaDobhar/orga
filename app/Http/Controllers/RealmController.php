<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRealmRequest;
use App\Http\Requests\UpdateRealmRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\RealmRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RealmController extends AppBaseController
{
    /** @var RealmRepository $realmRepository*/
    private $realmRepository;

    public function __construct(RealmRepository $realmRepo)
    {
        $this->realmRepository = $realmRepo;
    }

    /**
     * Display a listing of the Realm.
     */
    public function index(Request $request)
    {
        return view('realms.index');
    }

    /**
     * Show the form for creating a new Realm.
     */
    public function create()
    {
        return view('realms.create');
    }

    /**
     * Store a newly created Realm in storage.
     */
    public function store(CreateRealmRequest $request)
    {
        $input = $request->all();

        $realm = $this->realmRepository->create($input);

        Flash::success('Realm saved successfully.');

        return redirect(route('realms.index'));
    }

    /**
     * Display the specified Realm.
     */
    public function show($id)
    {
        $realm = $this->realmRepository->find($id);

        if (empty($realm)) {
            Flash::error('Realm not found');

            return redirect(route('realms.index'));
        }

        return view('realms.show')->with('realm', $realm);
    }

    /**
     * Show the form for editing the specified Realm.
     */
    public function edit($id)
    {
        $realm = $this->realmRepository->find($id);

        if (empty($realm)) {
            Flash::error('Realm not found');

            return redirect(route('realms.index'));
        }

        return view('realms.edit')->with('realm', $realm);
    }

    /**
     * Update the specified Realm in storage.
     */
    public function update($id, UpdateRealmRequest $request)
    {
        $realm = $this->realmRepository->find($id);

        if (empty($realm)) {
            Flash::error('Realm not found');

            return redirect(route('realms.index'));
        }

        $realm = $this->realmRepository->update($request->all(), $id);

        Flash::success('Realm updated successfully.');

        return redirect(route('realms.index'));
    }

    /**
     * Remove the specified Realm from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $realm = $this->realmRepository->find($id);

        if (empty($realm)) {
            Flash::error('Realm not found');

            return redirect(route('realms.index'));
        }

        $this->realmRepository->delete($id);

        Flash::success('Realm deleted successfully.');

        return redirect(route('realms.index'));
    }
}
