<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSymptomRequest;
use App\Http\Requests\UpdateSymptomRequest;
use App\Repositories\SymptomRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class SymptomController extends AppBaseController
{
    /** @var SymptomRepository $symptomRepository*/
    private $symptomRepository;

    public function __construct(SymptomRepository $symptomRepo)
    {
        $this->symptomRepository = $symptomRepo;
    }

    /**
     * Display a listing of the Symptom.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $symptoms = $this->symptomRepository->all();

        return view('symptoms.index')
            ->with('symptoms', $symptoms);
    }

    /**
     * Show the form for creating a new Symptom.
     *
     * @return Response
     */
    public function create()
    {
        return view('symptoms.create');
    }

    /**
     * Store a newly created Symptom in storage.
     *
     * @param CreateSymptomRequest $request
     *
     * @return Response
     */
    public function store(CreateSymptomRequest $request)
    {
		$input = $request->all();
		$repo = $this->symptomRepository;
		$storeFunc = function () use ($input, $repo) {
			$repo->create($input);
		};

		if ($this->tryStore($storeFunc)) {
			Flash::success('Symptom saved successfully.');
		} else {
			Flash::error('Same Symptom already stored or input is invalid');
		}

        return redirect(route('symptoms.index'));
    }

    /**
     * Display the specified Symptom.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $symptom = $this->symptomRepository->find($id);

        if (empty($symptom)) {
            Flash::error('Symptom not found');

            return redirect(route('symptoms.index'));
        }

        return view('symptoms.show')->with('symptom', $symptom);
    }

    /**
     * Show the form for editing the specified Symptom.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $symptom = $this->symptomRepository->find($id);

        if (empty($symptom)) {
            Flash::error('Symptom not found');

            return redirect(route('symptoms.index'));
        }

        return view('symptoms.edit')->with('symptom', $symptom);
    }

    /**
     * Update the specified Symptom in storage.
     *
     * @param int $id
     * @param UpdateSymptomRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSymptomRequest $request)
    {
        $symptom = $this->symptomRepository->find($id);

        if (empty($symptom)) {
            Flash::error('Symptom not found');
            return redirect(route('symptoms.index'));
        }

		$repo = $this->symptomRepository;
		$input = $request->all();
		$storeFunc = function () use ($input, $repo, $id) {
			$repo->update($input, $id);
		};

		if ($this->tryStore($storeFunc)) {
			Flash::success('Symptom updated successfully.');
		} else {
			Flash::error('Same symptom already stored or input is invalid');
		}

        return redirect(route('symptoms.index'));
    }

    /**
     * Remove the specified Symptom from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $symptom = $this->symptomRepository->find($id);

        if (empty($symptom)) {
            Flash::error('Symptom not found');

            return redirect(route('symptoms.index'));
        }

        $this->symptomRepository->delete($id);

        Flash::success('Symptom deleted successfully.');

        return redirect(route('symptoms.index'));
    }
}
