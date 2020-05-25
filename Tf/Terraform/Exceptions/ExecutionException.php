<?php

namespace Tf\Terraform\Exceptions;

class ExecutionException extends \RuntimeException
{
    protected $code = 500;
}