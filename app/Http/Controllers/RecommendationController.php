<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRecommendationRequest;
use App\Http\Requests\UpdateRecommendationRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\RecommendationRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RecommendationController extends AppBaseController
{
    /** @var RecommendationRepository $recommendationRepository*/
    private $recommendationRepository;

    public function __construct(RecommendationRepository $recommendationRepo)
    {
        $this->recommendationRepository = $recommendationRepo;
    }

    /**
     * Display a listing of the Recommendation.
     */
    public function index(Request $request)
    {
        return view('recommendations.index');
    }

    /**
     * Show the form for creating a new Recommendation.
     */
    public function create()
    {
        return view('recommendations.create');
    }

    /**
     * Store a newly created Recommendation in storage.
     */
    public function store(CreateRecommendationRequest $request)
    {
        $input = $request->all();

        $recommendation = $this->recommendationRepository->create($input);

        Flash::success('Recommendation saved successfully.');

        return redirect(route('recommendations.index'));
    }

    /**
     * Display the specified Recommendation.
     */
    public function show($id)
    {
        $recommendation = $this->recommendationRepository->find($id);

        if (empty($recommendation)) {
            Flash::error('Recommendation not found');

            return redirect(route('recommendations.index'));
        }

        return view('recommendations.show')->with('recommendation', $recommendation);
    }

    /**
     * Show the form for editing the specified Recommendation.
     */
    public function edit($id)
    {
        $recommendation = $this->recommendationRepository->find($id);

        if (empty($recommendation)) {
            Flash::error('Recommendation not found');

            return redirect(route('recommendations.index'));
        }

        return view('recommendations.edit')->with('recommendation', $recommendation);
    }

    /**
     * Update the specified Recommendation in storage.
     */
    public function update($id, UpdateRecommendationRequest $request)
    {
        $recommendation = $this->recommendationRepository->find($id);

        if (empty($recommendation)) {
            Flash::error('Recommendation not found');

            return redirect(route('recommendations.index'));
        }

        $recommendation = $this->recommendationRepository->update($request->all(), $id);

        Flash::success('Recommendation updated successfully.');

        return redirect(route('recommendations.index'));
    }

    /**
     * Remove the specified Recommendation from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $recommendation = $this->recommendationRepository->find($id);

        if (empty($recommendation)) {
            Flash::error('Recommendation not found');

            return redirect(route('recommendations.index'));
        }

        $this->recommendationRepository->delete($id);

        Flash::success('Recommendation deleted successfully.');

        return redirect(route('recommendations.index'));
    }
}
