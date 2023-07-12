<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConfigurationRequest;
use App\Http\Requests\UpdateConfigurationRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ConfigurationRepository;
use Illuminate\Http\Request;
use Flash;

class ConfigurationController extends AppBaseController
{
    /** @var ConfigurationRepository $configurationRepository*/
    private $configurationRepository;

    public function __construct(ConfigurationRepository $configurationRepo)
    {
        $this->configurationRepository = $configurationRepo;
    }

    /**
     * Display a listing of the Configuration.
     */
    public function index(Request $request)
    {
        return view('configurations.index');
    }

    /**
     * Show the form for creating a new Configuration.
     */
    public function create()
    {
        return view('configurations.create');
    }

    /**
     * Store a newly created Configuration in storage.
     */
    public function store(CreateConfigurationRequest $request)
    {
        $input = $request->all();

        $configuration = $this->configurationRepository->create($input);

        Flash::success('Configuration saved successfully.');

        return redirect(route('configurations.index'));
    }

    /**
     * Display the specified Configuration.
     */
    public function show($id)
    {
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        return view('configurations.show')->with('configuration', $configuration);
    }

    /**
     * Show the form for editing the specified Configuration.
     */
    public function edit($id)
    {
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        return view('configurations.edit')->with('configuration', $configuration);
    }

    /**
     * Update the specified Configuration in storage.
     */
    public function update($id, UpdateConfigurationRequest $request)
    {
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        $configuration = $this->configurationRepository->update($request->all(), $id);

        Flash::success('Configuration updated successfully.');

        return redirect(route('configurations.index'));
    }

    /**
     * Remove the specified Configuration from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $configuration = $this->configurationRepository->find($id);

        if (empty($configuration)) {
            Flash::error('Configuration not found');

            return redirect(route('configurations.index'));
        }

        $this->configurationRepository->delete($id);

        Flash::success('Configuration deleted successfully.');

        return redirect(route('configurations.index'));
    }
}
