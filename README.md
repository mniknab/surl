# SURL
 
 [![Build Status](https://travis-ci.com/mniknab/surl.svg?branch=master)](https://travis-ci.com/mniknab/surl)

**SURL** is a package allowing you to shorten urls.

*By [Mohammad Niknab](https://github.com/mniknab)*
## Installation

### Composer

You can install this package via Composer by running this command: 

```
composer require mniknab/surl
```

### Laravel

#### Setup

>NOTE : The package will automatically register itself if you're using Laravel >= v5.5, so you can skip this section.

Once the package is installed, you can register the service provider in `config/app.php` in the `providers` array:
 
 ```php
 'providers' => [
     ...
     Mniknab\Surl\SurlServiceProvider::class,
 ],
 ```

#### Artisan commands

To publish the config, migrations and views files, run this command:
> To force publishing add `--force` flag.

```
php artisan vendor:publish --provider="Mniknab\Surl\SurlServiceProvider"
```

To create the tables, run this command:
```
php artisan migrate
```

## Configuration

**Surl** configuration file can be found on ``` config/surl.php ``` 

## Usage

> NOTE: You can also use Surl as an API.

Go to  `http://{your-project}/surl-management`


