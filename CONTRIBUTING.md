Get the repository to yourself
```powershell
git clone git@github.com:Polkryptex/Polkryptex.git FOLDER_NAME
```

Go to the folder and run Composer to install the missing libraries
```powershell
cd 'FOLDER_NAME'
composer install
```

When you're done with the changes, change branch and send a commit
```powershell
git checkout -b pr/FEATURE_NAME
git add .
git commit -m 'FEATURE_NAME or whatever'
git push --set-upstream origin pr/FEATURE_NAME
```

Create new pull request from this feature

## Sample PHPCS validation
```powershell
phpcs --standard=D:\www\projects\polkryptex-git\phpcs.xml -s D:\www\projects\polkryptex-git\app\core\Bootstrap.php
```

## Sample password
```powershell
1bmTQrWoOYvjjD6TNCjVZCuZX7m0E4cVsC5kZ@
```