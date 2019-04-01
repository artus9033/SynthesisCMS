# SynthesisCMS

<p>
  <img align="middle" width="10%" src="https://github.com/artus9033/SynthesisCMS/raw/master/resources/assets/logos/dist/synthesiscms-icon.svg?sanitize=true">
  <strong>An amazingly fast, simple and extendable content management system, built on top of Laravel</strong>
</p>

SynthesisCMS is an amazingly fast, simple and extendable content management system, built on top of Laravel.
Stunningly safe and designed both for humans and programmers.

## Installation

 - Install php & enable php modules required by Laravel: mbstring, dom, pdo, json, bcmath, gd.
 - Clone the repo (`git clone https://github.com/artus9033/synthesiscms`)
 - `chown` the `public` & `storage` directories recursively for the proper user, e.g. `chown -R www-data:www-data storage` (repeat for `public`)
 - set read/write permissions on the `storage` & `cache` directories, using the script `setup_permissions.sh`
 - `npm install`
 - Compile the assets: `npm run prod` (or `npm run dev` for development, does not compress the files)
 - Configure the DB user, password & server parameters in `.env`
 - Install PHP modules required by Laravel: `apt install php-mbstring php-pdo php-tokenizer php-json php-xml php-ctype php-bcmath php-gd`
 - `apt install composer zip`
 - `composer install`
 - Migrate & seed DB tables: `composer install-database`
 - Optionally: it is advised not to place the CMS in your server's public directory, although the CMS has .htaccess files configured to protect critical files & source code from being accessed remotely. You should place the CMS outside of this directory and create a symlink to the `public` directory instead
 
 Note: make sure to enable mod_rewrite on your server. This enables the CMS to handle all requests & *protects your config files from being accessed remotely via http in case you place the CMS root directory in your server's public directory*
 
 Done! Your SynthesisCMS instance should be up & running.

## License

The SynthesisCMS project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
