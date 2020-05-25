<?php

namespace Tf\Terraform\Commands;
use Symfony\Component\Process\Process;

class TerraformAction extends AbstractTerraformCommand implements TerraformActionInterface
{
    private $supportedActions = ["init","apply","destroy","output"];

    public function action(string $action, string $argument = null): TerraformActionInterface 
    {
        $this->addCommand($action);
        
        if(!is_null($argument))
            $this->addOption($argument);

        return $this;
    }

    public function extraOptions(array $options): TerraformActionInterface
    {
        $this->addExtraOptions($options);
        return $this;
    }

    public function autoApprove():TerraformActionInterface
    {
        $this->addExtraOptions(['-auto-approve']);
        return $this;
    }

    public function vars(array $vars): TerraformActionInterface
    {
        $this->addVars($vars);
        return $this;
    }
    
    public function execute($callback = null)
    {
        return $this->runProcess($callback);
    }

    public function getCommand() :string
    {
        return join(" ", $this->prepareCommand());
    }

    public function __call($funName, $arguments) 
    {
        if(in_array($funName, $this->supportedActions)) 
        {
            $this->action($funName, current($arguments));
            return $this;
        }
    }
}