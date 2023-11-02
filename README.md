
# Orchard Skills Test - Kenneth Yu

This project is using Bedrock as a framework and DDEV for local development.



## What's in the project?

**Wordpress:** 6.3.2

**Theme:** Twenty Twenty

**Plugins:** ACF Pro, Product of the Day - Custom Plugin

I have included the .env.example file, plugins and uploads folders (not recommended) on this respository for setting up purposes.

## WP Admin username and password
U: admin

P: XxHjYPR9j@zHbE#6
## Requirements

- PHP (8.0)

- MariaDB (10.4)

- Composer

- Chocolatey (Optional)

- Docker (Optional)

- WSL (Optional)

Note that if we use DDEV, the PHP version and the database used are already configured in **config.yml** file.
## Let's start!

If you would like to use DDEV as your local development, follow the instructions below. Since this is using Bedrock as a framework, the file structure of the WordPress site is different. If you are using MAMP Pro, just set the web root to **web**

Note that **web** is the same with **public_html** in what we see in cPanels
## Composer

Install composer if you don't have one.

Download it from [here](https://getcomposer.org/download/)


## WSL

Install Windows Subsystem for Linux

```bash
wsl --install
```
or
Install it from [Microsoft Store](https://apps.microsoft.com/detail/windows-subsystem-for-linux/9P9TQF7MRM4R?hl=en-US&gl=US)

## Docker
Install Docker from [here](https://www.docker.com/products/docker-desktop/)

## DDEV
Paste this command in an elevated access of PowerShell to install chocolatey if you don't have one

```bash
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://chocolatey.org/install.ps1'))

```

Install DDEV
```bash
choco install ddev
```

Install mkcert of you don't have one
```bash
choco install -y mkcert
```

To enable https for this project, run this command
```bash
mkcert -install
```
## Set up the site

Run composer to install dependencies

```bash
composer install
```

## Running the site

To start the project, run the following:
```bash
ddev start
ddev launch
```
Site is accessbile through https://orchard.ddev.site

You should be able to access phpmyadmin using https://orchard.ddev.site:8037 if not, install phpmyadmin and then restart

```bash
ddev get ddev/ddev-phpmyadmin
ddev restart
```
## Environment Variables

To run this project, you will need to add the following environment variables to your .env file, for this setup you can just copy everything from .env.example


`DB_NAME`

`DB_USER`

`DB_PASSWORD`

`DB_HOST`

`WP_HOME`

Note that when using DDEV, all db details are using **db** and our current WP_HOME is set to https://orchard.ddev.site

Database file is in the repository named **database.sql**