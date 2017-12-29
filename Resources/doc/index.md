Getting Started With Fxp RoutingExtraBundle
===============================================

## Prerequisites

This version of the bundle requires Symfony 3.

## Installation

Installation is a quick, 2 step process:

1. Download the bundle using composer
2. Enable the bundle

### Step 1: Download the bundle using composer

Tell composer to download the bundle by running the command:

```bash
$ composer require routing-extra-bundle
```

Composer will install the bundle to your project's `vendor/fxp` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Fxp\Bundle\RoutingExtraBundle\FxpRoutingExtraBundle(),
    );
}
```

### Next Steps

Now that you have completed the basic installation and configuration of the
Fxp RoutingExtraBundle, you are ready to learn about usages of the bundle.
