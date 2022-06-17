<?php

namespace App\Http\Controllers;

use App\FuzzyLogic\Sugeno\Service;
use App\Models\Symptom;
use App\Models\Term;
use Illuminate\Http\Request;

class SearchDeceaseController extends Controller
{
    public function input(Request $request)
	{
		$data['terms'] = Term::factory()->newModel()->newQuery()->orderBy('name')->get()->toArray();
		$data['symptoms'] = Symptom::factory()->newModel()->newQuery()->orderBy('name')->get()->toArray();

		return view('search.disease.input')->with('data', $data);
	}

	public function result(Request $request)
	{
		$input = $request->all();
		try {
			$mamdaniService = new Service($input);
			$result = $mamdaniService->getViewResult();
		} catch (\Throwable $e) {
			return redirect()->back();
		}

		return view('search.disease.result')->with('result', $result);
	}
}
