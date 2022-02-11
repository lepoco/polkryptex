![logo](https://raw.githubusercontent.com/Polkryptex/Polkryptex/main/src/img/logo.svg)

# Polkryptex - Cryptocurrency exchange platform
Web application for managing currencies (including cryptocurrencies) created with the use of modern web application implementation techniques.  
Carried out as part of a team IT project.  
**Kazimierz Wielki University, Bydgoszcz, Poland**  
[https://www.ukw.edu.pl/](https://www.ukw.edu.pl/)  

**Polkryptex won the award for the best implemented IT application at the UKW university in 2022.**

## Depencies
The application uses several solutions to improve work and design. They are necessary to work on it.
- Composer 2.2.1 - [getcomposer.org](https://getcomposer.org/download/)
- PHP 8.1.1 - [php.net](https://windows.php.net/download#php-8.1)
- Node JS - [nodejs.org](https://nodejs.org/en/download/)

## Modules
- [x] URL Routing
- [x] Accepting Ajax requests
- [x] Automated installer
- [x] Toast notifications
- [x] Translations
- [x] User accounts
- [x] User roles
- [x] User permissions
- [x] Login and registration
- [x] Account confirmation via e-mail
- [x] Statistics module
- [x] E-mails
- [x] User wallets
- [x] CRON jobs
- [x] Redis as cache database
- [x] Transactions module
- [x] Internal payment system combined with the account balance of user accounts
- [x] Top-up module
- [ ] Service provider for Top-up module (PayPal /= PayU)
- [x] Cryptocurrency exchange system
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

## Security
The platform is intended to provide the possibility of processing money, hence we must ensure the appropriate safety of users.  
First, as this is a college project, we omitted full database encryption for time and computational power reasons.

 - **Salts**  
   When installing the application, a random set of salts is created based on the Mersenne Twister Random Number Generator using the time code encoded in CRC32. Based on this algorithm, random characters are selected from the array that are the salt component with a length of 64 characters.
 - **Logging in**  
   In successful scenarios, the password is encrypted one-way using the Argon2 algorithm and then stored in the database. In addition to the password, we store the session ID encoded with the same algorithm and an additional session Token generated on the basis of salt. All three of these values are required to validate a user. During each activity.
 - **Timeout**  
   The time in minutes during which the user can remain inactive is determined by a defined option in the database. The timestamp information of the last action is stored in the session. Before performing the activity, it is verified if the difference is greater than the defined time and if so, the session is invalidated.
 - **Requests**  
   The website works solely on the basis of AJAX requests. Therefore, it cannot run without JavaScript. To make sure the queries are valid, a salt and timecode generated nonce is added to each query. This nonce is verified before the actual request logic, and its absence causes the action to be rejected.
 - **Content Security Policy**  
   The CSP header is added to the HTTP response. It tells the browser what URLs are allowed to download styles, fonts and scripts. Besides, in the header there is CSP NONCE which is required for inline scripts on the page to run.
 - **Digiset**  
   In addition to CSP, the headers also contain a digiset, which is a BASE64-encoded SHA512 checksum of the entire content of the site. The salt is calculated just before sending and guarantees the correct checksum of the content.
 - **Session Hijacking**  
   In addition to the basic protection against hijacking in the form of SSL, the session ID is reset during each action, which ensures that the ID matches the user.
 - **SQL Injection**  
   Application uses strong typing, which in the method arguments try to prevent sending false data under e.g. integer arguments. One of the protection vectors is building parameterized SQL queries with a predetermined structure. Thanks to which the queries cannot be modified. Besides, where possible, query does not use the argument received in request, but checks with e.g. switch whether the given argument is allowed at all.

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
   Install it on your computer in **Trusted Root Certification Authorities** and select it in **VritualHost**.
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

## License
Polkryptex is free and open source software licensed under GNU GPL-3.0 License. You can use it in private and commercial projects.
Keep in mind that you must include a copy of the license in your project.