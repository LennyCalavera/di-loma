<?php

namespace App\Console\Commands;

use App\Models\Rule;
use App\Models\Symptom;
use App\Models\Term;
use Illuminate\Console\Command;

class CheckRules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:checkRules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$this->info('Check started ' . date('H:i:s'));

		$rulesArr = Rule::factory()->newModel()->newQuery()->select(['disease', 'id', 'conditions'])->groupBy('disease', 'id', 'conditions')->get()->toArray();
		$ruleDuplicates = RuleChecker::findRuleDuplicates($rulesArr);
		if (!empty($ruleDuplicates)) {
			$this->error('В правилах присутствуют дубликаты:');
			$this->comment(implode(' ', $ruleDuplicates));
			$this->error('Check finished ' . date('H:i:s'));
			return 0;
		}

		$testResult = RuleChecker::rulesLogicTest($rulesArr);

		foreach ($testResult as $data) {
			$this->newLine();
			$this->alert($data['disease']);
			$this->newLine();

			if (isset($data['noResult'])) {
				foreach ($data['noResult'] as $row) {
					$this->error('Диагноз отсутствует в результатe:');
					$this->line($row);
				}
				$this->newLine();
			}

			if (isset($data['notFirst'])) {
				foreach ($data['notFirst'] as $row) {
					$this->error('Степень истинности диагноза не наивысшая в результате:');
					$this->line($row);
				}
				$this->newLine();
			}

			if (isset($data['lower50'])) {
				foreach ($data['lower50'] as $row) {
					$this->error('Степень истинности диагноза менее 50%:');
					$this->line($row);
				}
				$this->newLine();
			}
		}
		$this->info('Check finished ' . date('H:i:s'));

		return 0;
    }
}
