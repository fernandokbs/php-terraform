<?php 
declare(strict_types=1);

namespace Tf\Terraform\Process;

use Symfony\Component\Process\Process;

interface BuilderInterface
{
    public function setArguments(array $args): BuilderInterface;
    public function setTimeout(int $timeout): BuilderInterface;
    public function getProcess(): Process;
}