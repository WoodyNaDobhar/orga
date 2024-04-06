<?php

namespace App\Console\Commands\Local;

use InfyOm\Generator\Commands\BaseCommand;
use Illuminate\Support\Composer;
use InfyOm\Generator\Common\GeneratorConfig;
use InfyOm\Generator\Utils\TableFieldsGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Pluralizer;

class GenerateSchema extends BaseCommand
{
	public GeneratorConfig $config;
	
	public Composer $composer;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'make:schema {model?}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new json schema file(s) for a given model, or all models if none specified.';
	
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		define('__NSMODEL__', '\\App\\Models\\');
		
		$this->config = new GeneratorConfig();
	}
	
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		if ($this->argument('model')) {
			$this->getMyFields($this->argument('model'));
			$this->saveMySchemaFile($this->argument('model'));
		}else{
			$models = $this->getModels("app/Models");
			foreach($models as $model){
				$this->getFields($model);
				$this->saveSchemaFile();
			}
		}
	}
	
	private function getModels($path){
		$out = [];
		$results = scandir($path);
		foreach ($results as $result) {
			if ($result === '.' or $result === '..' or $result === 'BaseModel.php') continue;
			$filename = $result;
			if (is_dir($filename)) {
				$out = array_merge($out, getModels($filename));
			}else{
				$out[] = substr($filename,0,-4);
			}
		}
		return $out;
	}
	
	public function getMyFields($model)
	{
		$tableName = Pluralizer::plural(lcfirst($model));
		$ignoredFields = [];
		$tableFieldsGenerator = new TableFieldsGenerator($tableName, $ignoredFields, $this->config->connection);
		$tableFieldsGenerator->prepareFieldsFromTable();
		$tableFieldsGenerator->prepareRelations();
		$this->config->fields = $tableFieldsGenerator->fields;
		$this->config->relations = $tableFieldsGenerator->relations;
	}
	
	protected function saveMySchemaFile($model)
	{
		$fileFields = [];
		
		foreach ($this->config->fields as $field) {
			$fileFields[] = [
				'name'        => $field->name,
				'dbType'      => $field->dbType,
				'htmlType'    => $field->htmlType,
				'validations' => $field->validations,
				'searchable'  => $field->isSearchable,
				'fillable'    => $field->isFillable,
				'primary'     => $field->isPrimary,
				'inForm'      => $field->inForm,
				'inIndex'     => $field->inIndex,
				'inView'      => $field->inView,
			];
		}
		
		foreach ($this->config->relations as $relation) {
			$fileFields[] = [
				'type'     => 'relation',
				'relation' => $relation->type.','.implode(',', $relation->inputs),
			];
		}
		
		$path = config('laravel_generator.path.schema_files', resource_path('model_schemas/'));
		
		$fileName = $model.'.json';
		
		if (file_exists($path.$fileName) && !$this->confirmOverwrite($fileName)) {
			return;
		}
		g_filesystem()->createFile($path.$fileName, json_encode($fileFields, JSON_PRETTY_PRINT));
		$this->comment("\nSchema File saved: ");
		$this->info($fileName);
	}
	
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['model', InputArgument::REQUIRED, 'Singular Model name'],
		];
	}
}