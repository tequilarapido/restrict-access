

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tequilarapido/restrict-access.svg?style=flat-square)](https://packagist.org/packages/tequilarapido/restrict-access)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/74390323/shield)](https://styleci.io/repos/74390323)
[![Quality Score](https://img.shields.io/scrutinizer/g/tequilarapido/restrict-access.svg?style=flat-square)](https://scrutinizer-ci.com/g/tequilarapido/restrict-access)

<p align="center">
    <img src="" />
</p>


## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package using composer

``` bash
$ composer require tequilarapido/restrict-access
```

## Usage

- Add service provider
```
Tequilarapido\RestrictAccess\ServiceProvider::class,
```

- Add middlewares to kernel  
```
protected $routeMiddleware = [
        'restrict_access_by_ip' => RestrictAccessByIp::class,
        'restrict_access_by_basic_auth' => RestrictAccessByBasicAuthentication::class,
    ];
```

- Add middleware to routes on witch you need to restrict access

- Env file  
```
RESTRICT_ACCESS_BY_BASIC_AUTH_ENABLED=true
RESTRICT_ACCESS_BY_BASIC_AUTH_usename=username
RESTRICT_ACCESS_BY_BASIC_AUTH_password=password

RESTRICT_ACCESS_BY_IP_ENABLED=false
RESTRICT_ACCESS_BY_IP_ENABLED_EXCEPT=a,b,c
```


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.






