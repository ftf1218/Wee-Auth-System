# Wee-Auth-System
> A Auth System, Built with PHP

Next, we will call `Wee-Auth-System`: `WAS`, it's same like `was`(passive of `is`)

## Features

WAS can finish the works like the list:

- **Domain Check** -- User convenition feature
- **SESSION** -- Prevent the CC Attack
- **Card-Password** -- Quick authorization
- **Download with QR code** -- More safety(This is TODO)
- **Quickly Check API** -- Check authorization more convenient

## Quick install

- git clone this repo ot download repo zip

- Access index page, it will redirect you to install page

- Just follow steps notice

- Default user & password:

  `User：`admin

  `Password：`123456

## API setting

this is a `public API`, it can work with remote resource, like Github Raw

How to modify API:

- Open site root dir
- Open `check.php`
- please modify `$file, $version`

If you use remote resouce to control version setting, you can do like this:

```php
$file = 'https://github.com/wibus-wee/STY-static/raw/main/.ver'; //remote resource URL
$version = file_get_contents($file); //it can't use get_curl, reason is finding
$version= str_replace(array("\r\n", "\r", "\n"), "", $version);  //replace PHP line break
```

else, if you want to just modify variable to control,

```php
$version = '1.0.0'; //just like this, it works!
```

## QR code

This is a todo option, here are the problem lead to this option can't use

- QQ old interface have a authorization check, it will return `403`
- Without new interface to use

## Card-Password

It can add a authorization in a quickly way, but only support one domain

How to create c-p: 

- Open `admin` with administrator name & password
- Open `Generate camilo` on index page
- Put create-number in the inputBox
- Click Create Camilo and wait for reloading

## Permissions distribution

- `Domestic consumer`, it only has **add** and **addsite** permissions
- `Assistant station master`, it has a full permission like administration
- `Banned users`, it can do nothing
