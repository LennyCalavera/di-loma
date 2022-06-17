<?php

namespace App\Console\Commands;

use App\Models\Disease;
use App\Models\Rule;
use App\Models\Symptom;
use App\Models\Term;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class ParseInitialData extends Command
{
	private const DEFAULT_DATA_FILE_NAME = 'DefaultData.json';
	private const OPERATION_TYPE_OR = 'or';
	private const OPERATION_TYPE_AND = 'and';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:parseConfig';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refills DB tables by default config file';

	private static array $operationTypes = [
		self::OPERATION_TYPE_OR,
		self::OPERATION_TYPE_AND,
	];

	/**
	 * @throws \Exception
	 */
	private function checkOperationType(string $operationType, int $ruleId): void
	{
		if (!in_array($operationType, self::$operationTypes)) {
			throw new \Exception('Unknown operation type ' . $operationType . ' in rule ' . $ruleId);
		}
	}

	private function parseDiseasesCollection($diseases): Collection
	{
		$diseases = collect($diseases)->each(function ($item, $key) {
			if (!isset($item['name'], $item['description'])) {
				throw new \Exception('Disease ' . $key . 'definition is incomplete');
			}
		});
		return $diseases;
	}

	private function parseTermsCollection($terms): Collection
	{
		$terms = collect($terms)->each(function ($item, $key) {
			if (!isset($item['name'], $item['minBorder'], $item['maxBorder'])) {
				throw new \Exception('Term ' . $key . ' definition is incomplete');
			}
			if (
				!is_numeric($item['minBorder']) ||
				!is_numeric($item['maxBorder']) ||
				$item['minBorder'] >= $item['maxBorder']
			) {
				throw new \Exception('Term ' . $key . ' borders are invalid');
			}
		});
		return $terms;
	}

	private function getRuleErrorTrace(int $ruleId, int $condId = null, int $subCondId = null): string
	{
		$result = 'Rule ' . ++$ruleId;
		if (isset($condId)) {
			$result .= ' condition ' . ++$condId;
		}
		if (isset($subCondId)) {
			$result .= ' subCondition ' . ++$subCondId;
		}
		return $result;
	}

	private function parseSymptomsCollection($symptoms): Collection
	{
		$symptoms = collect($symptoms)->map(function ($item, $key) {
			if (!isset($item['name'], $item['name'])) {
				throw new \Exception('Symptom ' . $key . ' definition is incomplete');
			}
			if (isset($item['minBorder']) !== isset($item['minBorder'])) {
				throw new \Exception('Symptom ' . $key . ' borders definition is incomplete');
			} else {
				$item['minBorder'] = $item['minBorder'] ?? 0;
				$item['maxBorder'] = $item['maxBorder'] ?? 100;
			}

			return $item;
		});
		return $symptoms;
	}

	private function parseRules(
		array $rules,
		Collection $diseases,
		Collection $terms,
		Collection $symptoms
	): array {
		foreach ($rules as $ruleId => $rule) {
			if (
				!isset($rule['conditionsOperationType'], $rule['conditions'], $rule['weight'], $rule['disease']) ||
				empty($rule['conditions'])
			) {
				throw new \Exception($this->getRuleErrorTrace($ruleId) . ' definition is incomplete');
			}
			$this->checkOperationType($rule['conditionsOperationType'], $ruleId);
			if (
				!is_numeric($rule['weight']) ||
				$rule['weight'] < 0 ||
				$rule['weight'] > 1
			) {
				throw new \Exception($this->getRuleErrorTrace($ruleId) . ' weight is incorrect: ' . $rule['weight']);
			}
			if ($diseases->doesntContain('name', $rule['disease'])) {
				throw new \Exception($this->getRuleErrorTrace($ruleId) . ' has undefined disease: ' . $rule['disease']);
			}

			foreach ($rule['conditions'] as $condId => $condition) {
				if (
					!isset($condition['subConditionsOperationType'], $condition['subConditions']) ||
					empty($condition['subConditions'])
				) {
					throw new \Exception($this->getRuleErrorTrace($ruleId, $condId) . ' definition is incomplete');
				}
				$this->checkOperationType($condition['subConditionsOperationType'], $ruleId);
				foreach ($condition['subConditions'] as $subCondId => $subCondition) {
					if (!isset($subCondition['term'], $subCondition['symptom'])) {
						throw new \Exception($this->getRuleErrorTrace($ruleId, $condId, $subCondId) . ' definition is incomplete');
					}
					if ($terms->doesntContain('name', $subCondition['term'])) {
						throw new \Exception($this->getRuleErrorTrace($ruleId, $condId, $subCondId) . ' has unknown term');
					}
					if ($symptoms->doesntContain('name', $subCondition['symptom'])) {
						throw new \Exception($this->getRuleErrorTrace($ruleId, $condId, $subCondId) . ' has unknown symptom');
					}
				}
			}

			$rules[$ruleId]['conditions'] = json_encode($rule['conditions'], JSON_UNESCAPED_UNICODE);
		}

		return $rules;
	}

	/**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$this->info('Initiation started! ' . date('H:i:s'));

		try {
			if (Storage::missing('public/' . self::DEFAULT_DATA_FILE_NAME)) {
				throw new \Exception('Data not found. Put ' . self::DEFAULT_DATA_FILE_NAME . ' file into storage/app/public/');
			}
			$data = Storage::get('public/' . self::DEFAULT_DATA_FILE_NAME);
			$data = json_decode($data, true, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
			if (
				empty($data['rules']) ||
				empty($data['terms']) ||
				empty($data['diseases']) ||
				empty($data['symptoms'])
			) {
				throw new \Exception('Data is incomplete. You must define keys: rules, terms, diseases, symptoms');
			}

			$symptoms = $this->parseSymptomsCollection($data['symptoms']);
			$terms = $this->parseTermsCollection($data['terms']);
			$diseases = $this->parseDiseasesCollection($data['diseases']);
			$rules = $this->parseRules($data['rules'], $diseases, $terms, $symptoms);

			Symptom::truncate();
			Term::truncate();
			Disease::truncate();
			Rule::truncate();

			$this->info('Data tables cleared');

			DB::table('symptoms')->insert($symptoms->toArray());
			DB::table('terms')->insert($terms->toArray());
			DB::table('diseases')->insert($diseases->toArray());
			DB::table('rules')->insert($rules);

			$this->info('Initiation finished successful! ' . date('H:i:s'));
		} catch (\Throwable $e) {
			$this->error($e->getMessage());
		}

		return 0;
    }
}
