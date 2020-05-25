<?php

namespace Tf\Terraform\Commands;

use Tf\Terraform\Process\BuilderInterface;

abstract class AbstractTerraformCommand
{
    private $builder;
    private $commands;
    private $options;
    private $vars;

    public function __construct(BuilderInterface $builder)
    {
        $this->commands = ["terraform"];
        $this->builder = $builder;
        $this->options = [];
        $this->vars = [];
    }

    public function addCommand(string $command): void
    {
        array_push($this->commands, $command);
    }

    public function addVars(array $vars): void
    {
        $vars = array_map(function($item) {
            return "-var '{$item}'";
        }, $vars);

        if(empty($this->vars))
            $this->vars = $vars;
        else
            $this->vars = array_merge($this->vars, $vars);   
    }

    public function addOption(string $argument): void
    {
        array_push($this->options, $argument);
    }

    public function addExtraOptions(array $options): void 
    {
        if(empty($this->options))
            $this->options = $options;
        else
            $this->options = array_merge($this->options, $options);
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getVars(): array
    {
        return $this->vars;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function prepareCommand(): array
    {
        return array_merge($this->getCommands(), $this->getOptions(), $this->getVars());
    }

    public function runProcess($callback = null)
    {
        $process = $this->builder
            ->setArguments(
                $this->prepareCommand()
            )
            ->getProcess();
        
        $result = $process->run($callback);

        if(is_null($callback)) {
            $result = $process->getOutput();

            if ($process->isSuccessful() === false)
                $process->getErrorOutput();
        }

        return $result;
    }
}