<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class GenerateUseCase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:use-case {--module=} {--cases=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @param  Filesystem  $filesystem
     */
    public function __construct(protected Filesystem $filesystem)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $cases  = explode(',', $this->option('cases'));
        $module = Str::studly($this->option('module'));
        $types  = [
            'Controller',
            'Feature',
            'Transformer',
            'DTO',
            'Request',
            'Criteria',
            'Job',
        ];
        $this->makeDirectory($this->getSourceModulePath($module));
        foreach ($cases as $case) {
            $case = Str::studly($case);
            foreach ($types as $type) {
                $path = $this->getSourceFilePath($module, $case, $type);
                $this->makeDirectory(dirname($path));
                $contents = $this->getSourceFile($module, $case, $type);
                if ($contents) {
                    $this->filesystem->put($path, $contents);
                    $this->info("File: $path created");
                }
            }
        }
    }

    /**
     * Return the stub file path
     *
     * @param  string  $type
     * @return string
     */
    public function getStubPath(string $type): string
    {
        return __DIR__.'/../../../stubs/modules.'.Str::lower($type).'.stub';
    }

    /**
     * Map the stub variables present in stub to its value
     *
     * @param  string  $module
     * @param  string  $case
     * @param  string  $type
     * @return array
     */
    public function getStubVariables(string $module, string $case, string $type): array
    {
        return [
            'NAMESPACE'        => "App\\Modules\\$module\\$case",
            'CLASS_NAME'       => "$case$type",
            'FEATURE_NAME'     => $case.'Feature',
            'TRANSFORMER_NAME' => $case.'Transformer',
        ];
    }

    /**
     * Get the stub path and the stub variables
     *
     * @param  string  $module
     * @param  string  $case
     * @param  string  $type
     * @return string|array|bool
     */
    public function getSourceFile(string $module, string $case, string $type): string|array|bool
    {
        if ($this->filesystem->exists($path = $this->getStubPath($type))) {
            return $this->getStubContents($path, $this->getStubVariables($module, $case, $type));
        }

        return false;
    }


    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param  array  $stubVariables
     * @return string|array|bool
     */
    public function getStubContents($stub, array $stubVariables = []): string|array|bool
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$'.$search.'$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @param  string  $module
     * @param  string  $case
     * @param  string  $type
     * @return string
     */
    public function getSourceFilePath(string $module, string $case, string $type): string
    {
        return base_path('app/Modules')
            .'/'.Str::studly($module)
            .'/'.Str::studly($case)
            .'/'.Str::studly($case)
            .Str::studly($type).'.php';
    }

    /**
     * Get the full path of module directory
     *
     * @param  string  $module
     * @return string
     */
    public function getSourceModulePath(string $module): string
    {
        return base_path('app/Modules')
            .'/'.Str::studly($module);
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory(string $path): string
    {
        if (!$this->filesystem->isDirectory($path)) {
            $this->filesystem->makeDirectory($path);
        }

        return $path;
    }
}
