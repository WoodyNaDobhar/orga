<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMeetupRequest;
use App\Http\Requests\UpdateMeetupRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MeetupRepository;
use Illuminate\Http\Request;
use Flash;

class MeetupController extends AppBaseController
{
    /** @var MeetupRepository $meetupRepository*/
    private $meetupRepository;

    public function __construct(MeetupRepository $meetupRepo)
    {
        $this->meetupRepository = $meetupRepo;
    }

    /**
     * Display a listing of the Meetup.
     */
    public function index(Request $request)
    {
        return view('meetups.index');
    }

    /**
     * Show the form for creating a new Meetup.
     */
    public function create()
    {
        return view('meetups.create');
    }

    /**
     * Store a newly created Meetup in storage.
     */
    public function store(CreateMeetupRequest $request)
    {
        $input = $request->all();

        $meetup = $this->meetupRepository->create($input);

        Flash::success('Meetup saved successfully.');

        return redirect(route('meetups.index'));
    }

    /**
     * Display the specified Meetup.
     */
    public function show($id)
    {
        $meetup = $this->meetupRepository->find($id);

        if (empty($meetup)) {
            Flash::error('Meetup not found');

            return redirect(route('meetups.index'));
        }

        return view('meetups.show')->with('meetup', $meetup);
    }

    /**
     * Show the form for editing the specified Meetup.
     */
    public function edit($id)
    {
        $meetup = $this->meetupRepository->find($id);

        if (empty($meetup)) {
            Flash::error('Meetup not found');

            return redirect(route('meetups.index'));
        }

        return view('meetups.edit')->with('meetup', $meetup);
    }

    /**
     * Update the specified Meetup in storage.
     */
    public function update($id, UpdateMeetupRequest $request)
    {
        $meetup = $this->meetupRepository->find($id);

        if (empty($meetup)) {
            Flash::error('Meetup not found');

            return redirect(route('meetups.index'));
        }

        $meetup = $this->meetupRepository->update($request->all(), $id);

        Flash::success('Meetup updated successfully.');

        return redirect(route('meetups.index'));
    }

    /**
     * Remove the specified Meetup from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $meetup = $this->meetupRepository->find($id);

        if (empty($meetup)) {
            Flash::error('Meetup not found');

            return redirect(route('meetups.index'));
        }

        $this->meetupRepository->delete($id);

        Flash::success('Meetup deleted successfully.');

        return redirect(route('meetups.index'));
    }
}
