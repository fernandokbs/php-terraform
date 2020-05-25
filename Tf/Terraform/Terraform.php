<?php
declare(strict_types=1);

namespace Tf\Terraform;

use Tf\Terraform\Commands\{TerraformAction, TerrraformActionInterface};
use Tf\Terraform\Process\{BuilderInterface, Builder};
use Tf\Terraform\Exceptions\ExecutionException;

final class Terraform 
{
    private $plan;

    public function __construct(string $path)
    {
        $this->plan = $this->validateDir($path); 
    }

    private function createProccess(string $directory): BuilderInterface
    {
        return new Builder($directory);
    }

    private function validateDir(string $path): string
    {
        if (!is_dir($path))
            throw new ExecutionException("Invalid directory not found in {$path}.");

        return $path;
    }

    public function __call($funName, $arguments) 
    {
        return call_user_func_array([new TerraformAction($this->createProccess($this->plan)), $funName],  $arguments);
    }
}