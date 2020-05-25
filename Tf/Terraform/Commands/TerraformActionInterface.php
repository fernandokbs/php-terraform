<?php

namespace Tf\Terraform\Commands;

use Symfony\Component\Process\Process;

interface TerraformActionInterface 
{
    public function extraOptions(array $options): TerraformActionInterface;
    public function action(string $action, string $argument = null): TerraformActionInterface;
    public function autoApprove(): TerraformActionInterface;
    public function vars(array $vars): TerraformActionInterface;
    public function execute($callback = null);
    public function getCommand(): string;
}