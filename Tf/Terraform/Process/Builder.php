<?php 

namespace Tf\Terraform\Process;

use Symfony\Component\Process\Process;

class Builder implements BuilderInterface
{
    private $directory;

    private $timeout;

    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->arguments = [];
        $this->timeout = 3600;
    }

    public function setArguments($arguments): BuilderInterface
    {
        $this->arguments = $arguments;
        return $this;
    }

    public function setTimeout($timeout): BuilderInterface
    {
        $this->timeout = $timeout;
        return $this;
    }

    private function cdToDir(): array
    {
        return ["cd {$this->directory} &&"];
    }

    private function prepareCommand(): string
    {
        return join(" ", array_merge($this->cdToDir(), $this->arguments));
    }

    public function getProcess(): Process
    {
        return Process::fromShellCommandline($this->prepareCommand())
                ->setTimeout($this->timeout);
    }
}