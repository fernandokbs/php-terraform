<?php 

use Symfony\Component\Process\Process;
use PHPUnit\Framework\TestCase;
use Tf\Terraform\Exceptions\ExecutionException;
use Tf\Terraform\Terraform;

class TeraformTest extends TestCase 
{
    private $tf;

    public function setUp(): void
    {
        parent::setUp();
        $this->tf = (new Terraform(__DIR__ . "/__snapshots__"));
    }

    /** @test */
    public function exception_dir_not_found()
    {
        $this->expectException(ExecutionException::class);
        $tf = new Terraform("/home/foo");
    }

    /** @test */
    public function it_inits_file()
    {
        $this->tf->init()
            ->execute(function ($type, $buffer) {});
        
        $this->assertTrue(is_dir(__DIR__ . "/__snapshots__/.terraform"));
    }

    /** @test */
    public function it_applies_plan()
    {
        $output =  $this->tf->apply()
                        ->autoApprove()
                        ->getCommand();
        
        $this->assertEquals("terraform apply -auto-approve", $output);
    }


    /** @test */
    public function it_applies_plan_with_options()
    {
        $output =  $this->tf->apply()
                        ->autoApprove()
                        ->extraOptions([
                            '-no-color',
                            '-state=path',
                            '-backup=path'
                        ])
                        ->getCommand();
        
        $this->assertEquals("terraform apply -auto-approve -no-color -state=path -backup=path", $output);
    }

    /** @test */
    public function it_applies_plan_with_vars()
    {
        $output =  $this->tf->apply()
                        ->autoApprove()
                        ->vars([
                            'foo=bar',
                            'token=12309712903'
                        ])
                        ->getCommand();
        
        $this->assertEquals("terraform apply -auto-approve -var 'foo=bar' -var 'token=12309712903'", $output);
    }


    /** @test */
    public function it_applies_plan_with_options_and_vars()
    {
        $output =  $this->tf->apply()
                        ->autoApprove()
                        ->extraOptions([
                            '-no-color',
                            '-state=path',
                            '-backup=path'
                        ])
                        ->vars([
                            'foo=bar',
                            'token=12309712903'
                        ])
                        ->getCommand();
        
        $this->assertEquals("terraform apply -auto-approve -no-color -state=path -backup=path -var 'foo=bar' -var 'token=12309712903'", $output);
    }
}