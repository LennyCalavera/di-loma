<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRuleRequest;
use App\Http\Requests\UpdateRuleRequest;
use App\Repositories\RuleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class RuleController extends AppBaseController
{
    /** @var RuleRepository $ruleRepository*/
    private $ruleRepository;

    public function __construct(RuleRepository $ruleRepo)
    {
        $this->ruleRepository = $ruleRepo;
    }

    /**
     * Display a listing of the Rule.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $rules = $this->ruleRepository->all();

        return view('rules.index')
            ->with('rules', $rules);
    }

    /**
     * Show the form for creating a new Rule.
     *
     * @return Response
     */
    public function create()
    {
        return view('rules.create');
    }

    /**
     * Store a newly created Rule in storage.
     *
     * @param CreateRuleRequest $request
     *
     * @return Response
     */
    public function store(CreateRuleRequest $request)
    {
        $input = $request->all();

        $rule = $this->ruleRepository->create($input);

        Flash::success('Rule saved successfully.');

        return redirect(route('rules.index'));
    }

    /**
     * Display the specified Rule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rule = $this->ruleRepository->find($id);

        if (empty($rule)) {
            Flash::error('Rule not found');

            return redirect(route('rules.index'));
        }

        return view('rules.show')->with('rule', $rule);
    }

    /**
     * Show the form for editing the specified Rule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rule = $this->ruleRepository->find($id);

        if (empty($rule)) {
            Flash::error('Rule not found');

            return redirect(route('rules.index'));
        }

        return view('rules.edit')->with('rule', $rule);
    }

    /**
     * Update the specified Rule in storage.
     *
     * @param int $id
     * @param UpdateRuleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRuleRequest $request)
    {
        $rule = $this->ruleRepository->find($id);

        if (empty($rule)) {
            Flash::error('Rule not found');

            return redirect(route('rules.index'));
        }

        $rule = $this->ruleRepository->update($request->all(), $id);

        Flash::success('Rule updated successfully.');

        return redirect(route('rules.index'));
    }

    /**
     * Remove the specified Rule from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rule = $this->ruleRepository->find($id);

        if (empty($rule)) {
            Flash::error('Rule not found');

            return redirect(route('rules.index'));
        }

        $this->ruleRepository->delete($id);

        Flash::success('Rule deleted successfully.');

        return redirect(route('rules.index'));
    }
}
