<?php

namespace App\FuzzyLogic\Sugeno;

use App\Models\Disease;
use App\Models\Rule;
use App\Models\Symptom;
use App\Models\Term;
use Illuminate\Support\Collection;

class Service
{
	private const RESULT_DISEASES_COUNT = 3;

	/**
	 * @throws \Exception
	 */
	public function __construct(array $input)
	{
		$this->loadAdditionalData();
		$this->processInput($input);
		$this->setAppliedRules();
		$this->calcRulesDegreeOfTruth();
		$this->calcResult();
	}

	/**
	 * @var Collection<Disease>
	 */
	protected Collection $diseases;
	protected array $input = [];
	protected array $result = [];
	protected array $rules = [];
	/**
	 * @var Collection<Symptom>
	 */
	protected Collection $symptoms;
	/**
	 * @var Collection<Term>
	 */
	protected Collection $terms;

	private function calcResult(): void
	{
		$rulesByDisease = [];
		foreach ($this->rules as $rule) {
			$rulesByDisease[$rule['disease']][] = $rule;
		}

		foreach ($rulesByDisease as $diseaseName => $rules) {
			$DOT = 0;
			$rules = $this->addDiseaseDOT($rules);
			foreach ($rules as $rule) {
				$DOT += $rule['diseaseDOT'] * $rule['DOT'] / $rule['diseaseDOT']);
			}
			$diseaseDOT = $DOT / count($rules) * 100;
			$disease['DOT'] = round($diseaseDOT, 2);
			$disease['description'] = $this->diseases->firstWhere('name', '=', $diseaseName)->getAttributes()['description'];
			$disease['name'] = $diseaseName;
			$this->result[] = $disease;
		}

		$sortFn = function (array $a, array $b) {
			return $a['DOT'] < $b['DOT'];
		};
		usort($this->result, $sortFn);
	}

	private function calcRulesDegreeOfTruth(): void
	{
		foreach ($this->rules as $ruleID => $rule) {
			$ruleDOT = null;
			$condOper = $rule['conditionsOperationType'];
			foreach ($rule['conditions'] as $condition) {
				$conditionDOT = null;
				$subCondOper = $condition['subConditionsOperationType'];
				foreach ($condition['subConditions'] as $subCondition) {
					$value = $this->input[$subCondition['symptom']] ?? null;
					if (isset($value)) {
						$subConditionDOT = $this->getAffiliateVal($value, $subCondition['term'], $subCondition['symptom']);
						if (!isset($conditionDOT)) {
							$conditionDOT = $subConditionDOT;
						} elseif ($subCondOper === 'or') {
							$conditionDOT = max($conditionDOT, $subConditionDOT);
						} elseif ($subCondOper === 'and') {
							$conditionDOT = min($conditionDOT, $subConditionDOT);
						}
					} else {
						continue 2;
					}
				}
				if (!isset($ruleDOT)) {
					$ruleDOT = $conditionDOT ?? 0;
				} elseif ($condOper === 'or') {
					$ruleDOT = max($ruleDOT, $conditionDOT);
				} elseif ($condOper === 'and') {
					$ruleDOT = min($ruleDOT, $conditionDOT);
				}
			}
			$this->rules[$ruleID]['DOT'] = $ruleDOT * $this->rules[$ruleID]['weight'];
		}
	}

	private function getAffiliateValTriangle($value, string $termName): float
	{
		$a = $this->terms->firstWhere('name', '=', $termName)->getAttributes()['minBorder'];
		$c = $this->terms->firstWhere('name', '=', $termName)->getAttributes()['maxBorder'];
		$b = $a + (($c - $a) / 2);

		if ($a <= $value && $value <= $b) {
			return 1 - (($b - $value) / ($b - $a));
		} elseif ($b <= $value && $value <= $c) {
			return 1 - (($value - $b) / ($c - $b));
		} else {
			return 0;
		}
	}

	public function getViewResult()
	{
		return \array_slice($this->result, 0, self::RESULT_DISEASES_COUNT);
	}

	private function loadAdditionalData(): void
	{
		$this->diseases = Disease::factory()->newModel()->newQuery()->get();
		$this->symptoms = Symptom::factory()->newModel()->newQuery()->get();
		$this->terms = Term::factory()->newModel()->newQuery()->get();
	}

	private function processInput(array $input): void
	{
		if (empty($input)) {
			throw new \Exception('Empty input');
		}
		$compareSymptoms = $this->symptoms->each(function (Symptom $item) {
			$item->compareName = mb_strtolower($item->name);
			return $item;
		});
		foreach ($input as $symptom => $value) {
			if (!is_numeric($value)) {
				throw new \Exception('Input symptom ' . $symptom . ' has non numeric value ' . $value);
			}
			$symptom = str_replace('_', ' ', mb_strtolower($symptom));
			$knownSymptom = $compareSymptoms->where('compareName', $symptom);
			if ($knownSymptom->isEmpty()) {
				throw new \Exception('Invalid symptom: ' . $symptom);
			}

			$this->input[$knownSymptom->value('name')] = $value;
		}
	}

	private function setAppliedRules(): void
	{
		$appliedRulesArr = [];
		$inputSymptoms = [];
		foreach ($this->input as $symptom => $val) {
			$inputSymptoms[] = mb_strtolower($symptom);
		}
		Rule::factory()->newModel()->newQuery()->get()->each(function (Rule $rule) use ($inputSymptoms, &$appliedRulesArr) {
			$conditions = json_decode($rule->conditions, true, JSON_UNESCAPED_UNICODE);
			foreach ($conditions as $condition) {
				$appliedSymtoms = collect($condition['subConditions'])->reject(function (array $subCond) use ($inputSymptoms) {
					$symptom = mb_strtolower($subCond['symptom']);
					return !in_array($symptom, $inputSymptoms);
				});

				if ($appliedSymtoms->isNotEmpty()) {
					$appliedRule = $rule->getAttributes();
					$appliedRule['conditions'] = $conditions;
					$appliedRulesArr[] = $appliedRule;
					break;
				}
			}
		});

		$this->rules = $appliedRulesArr;
	}
}
