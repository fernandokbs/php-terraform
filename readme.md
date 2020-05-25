# Personal library

# Init

```php

$tf = new Terraform(plan_path);

$tf->init()
    ->execute();

// cd plan_path && terraform init

```

```php

$terraform->apply()
    ->autoApprove()
    ->extraOptions([
        '-backup=path',
        '-no-color',
    ])
    ->vars([
        'token=23947198234',
        'foo=bar'
    ])
    ->execute(function ($type, $buffer) {
        if (Process::ERR === $type)
            echo 'ERR > '.$buffer;
        else
            echo 'OUT > '.$buffer;
    });

// cd plan_path && terraform apply -auto-approve -backup=path -no-color -var 'token=23947198234' -var 'foo=bar'

```

```php

$tf->destroy()
    ->autoApprove()
    ->execute();

// cd plan_path && terraform destroy -auto-approve

```

```php

$output = "";

$output = $tf->output("ip")
    ->execute(null);

```