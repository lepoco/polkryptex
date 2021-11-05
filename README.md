![logo](https://raw.githubusercontent.com/Polkryptex/Polkryptex/main/src/img/logo.svg)

# Polkryptex - Cryptocurrency exchange platform
Web application for managing currencies (including cryptocurrencies) created with the use of modern web application implementation techniques.  
Carried out as part of a team IT project.  
**Kazimierz Wielki University, Bydgoszcz, Poland**  
[https://www.ukw.edu.pl/](https://www.ukw.edu.pl/)

## Depencies
The application uses several solutions to improve work and design. They are necessary to work on it.
- Composer - [getcomposer.org](https://getcomposer.org/download/)
- Node JS - [nodejs.org](https://nodejs.org/en/download/)
- PHP 8.0.11 - [php.net](https://windows.php.net/download#php-8.0)

## Modules
- [x] URL Routing
- [x] Accepting Ajax requests
- [x] Automated installer
- [x] Toast notifications
- [x] Translations
- [x] User accounts
- [ ] User roles
- [x] Login and registration
- [ ] Internal payment system combined with the account balance of user accounts
- [ ] Top-up module with service provider (PayPal /= PayU)
- [ ] Cryptocurrency exchange system
- [ ] Exchange of cryptocurrencies with their current rates and historical rates presented in the charts
- [ ] (Optional) Forecasting further rate of a given cryptocurrency
- [x] (Optional) PWA support

## Technologies & Tools
- **PHP** - *Scripting language responsible for the application logic.*
- **MySQL** - *Relational database system.*
- **Sass** - *Preprocessor for CSS.*
- **TypeScript** - *Strongly typed superset of JavaScript.*
- **webpack** - *JavaScript module bundler.*
- **WorkBox** - *Library for managing and creating Service Workers.*
- **Composer** - *PHP dependency management tool.*
- **NPM** - *JavaScript dependency management tool.*
- **PWA** - *Set of tools and technologies for building scalable web applications.*

## Timeline
- 01.06.2021 - Creation of CMS and base functionalities
- 01.07.2021 - User accounts and registration
- 01.08.2021 - User's wallet mechanism
- 01.09.2021 - Currency exchange capability
- 01.10.2021 - Connection to the cryptocurrency API
- 01.11.2021 - Implementing the PayPal API
- 01.12.2021 - Optional, PWA support

## How to run and install the application?
Several steps must be taken to properly run the application.  

 - First, copy the repository to the directory  
   *The **~polkryptex** directory is an example, it could be e.g. **C:\xampp\htdocs\polkryptex\***
   ```powershell
   git clone origin main https://github.com/Polkryptex/Polkryptex.git ~polkryptex
   ```

 - Go to the directory with the site
   ```powershell
   cd ~polkryptex
   ```

 - Install all PHP modules, enter comand in the application directory
   ```powershell
   composer install
   ```

 - Download all node modules, enter the command
   ```powershell
   npm install
   ```

 - Build all the resources and the startup directory
   ```powershell
   npm run build
   ```

 - If you are using **Apache HTTPD**, configure the virtual host to point to the **public** directory inside **~polkryptex**.
   ```xml
   <VirtualHost polkryptex.lan:80>
     DocumentRoot "~polkryptex\public"
     ServerName polkryptex.lan
   </VirtualHost>
   ```

 - If you are using **Apache HTTPD**, configure SSL for the domain.  
   Sample certifice [can be found here](https://github.com/Polkryptex/Polkryptex/tree/main/.sample_cert). Install it on your computer in **Trusted Root Certification Authorities** and select it in **VritualHost**.
   ```xml
   <VirtualHost polkryptex.lan:443>
     DocumentRoot "~polkryptex\public"
     ServerName polkryptex.lan
     SSLEngine on
     SSLCertificateFile "DIRECTORY_WITH_CERT\polkryptex.lan.crt"
     SSLCertificateKeyFile "DIRECTORY_WITH_CERT\polkryptex.lan.key"
   </VirtualHost>
   ```

 - If you are using *Windows*, add an entry to the **C:\Windows\System32\drivers\etc\hosts** file
   ```c
   127.0.0.1 polkryptex.lan
   ```

 - Now, go to **https://polkryptex.lan/** page in your browser and enter the database credentials. After installation, the application should work properly.


## Tests
To run all tests, in the root of the project, run the command:
```powershell
./vendor/bin/pest
```

## External solutions
- Node.js [nodejs.org](https://nodejs.org/en/)
- TypeScript [typescriptlang.org](https://www.typescriptlang.org/)
- Bramus Router [github.com/bramus](https://github.com/bramus/router)
- The Laravel Components [github.com/illuminate](https://github.com/illuminate)
- PHP Mailer [github.com/PHPMailer](https://github.com/PHPMailer/PHPMailer)
- Web Auth [github.com/web-auth](https://github.com/web-auth/webauthn-lib)
- Symfony var-dumper [symfony.com](https://symfony.com/doc/current/components/var_dumper.html)
- Pest [pestphp.com](https://pestphp.com/docs/writing-tests)
- Spatie Ray [spatie.be](https://spatie.be/products/ray)
- Bootstrap [getbootstrap.com](https://getbootstrap.com/docs/5.0/getting-started/introduction/)
- Webpack [webpack.js.org](https://webpack.js.org/)
- Webpack CLI [npmjs.com/package/webpack-cli](https://www.npmjs.com/package/webpack-cli)
- SASS [npmjs.com/package/sass](https://www.npmjs.com/package/sass)
- Workbox Webpack [npmjs.com/package/workbox-webpack-plugin](https://www.npmjs.com/package/workbox-webpack-plugin)

## Roles
- @Leszek - Core functions and Content Management System
- @Szymon - Databases & AJAX
- @Kacper - UI elements and APIs
- @Filip - Designing graphical interfaces, images and vectors
- @Paweł - Frontend