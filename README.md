# How to launch application

## Before launch application
Before launch application you must setup following environment variables:
- APP_ENV (default: dev)
- GITHUB_AUTH_METHOD (url_token/url_client_id/http_password/http_token/jwt)
- GITHUB_USERNAME (token/username/client)
- GITHUB_SECRET (password/secret)

Recommended way is use GitHub App credentials.
[How to create GitHub APP](https://developer.github.com/apps/building-github-apps/creating-a-github-app/). 
If you use application with GitHub App then environment variables look similar:
- GITHUB_AUTH_METHOD=url_client_id
- GITHUB_USERNAME=client_id
- GITHUB_SECRET=client_secret

You can set these variables in system globally or can provide in .env file placed 
in application root directory.  

### Standalone

For launch as local standalone application you need following tools:

- [Git](https://git-scm.com/downloads)
- [PHP 7](http://php.net/manual/en/install.php)
- [Composer](https://getcomposer.org/download)
- [NodeJs](https://nodejs.org/en/download/package-manager)
- [Yarn](https://yarnpkg.com/en/docs/install)

When you have all tools installed than run follow commands in app root directory:

```
composer install
```

```
php bin/console server:run 0.0.0.0:8000
```

After that open [http://0.0.0.0:8000](http://0.0.0.0:8000) in the browser.

### Docker
For launch application with docker you need following tools:
- [Docker](https://docs.docker.com/install/)

When you have all tools installed than run follow commands in app root directory:

```
docker-compose build
```

```
docker-compose run app composer install
```

```
docker-compose up
```

After that open [http://0.0.0.0:8000](http://0.0.0.0:8000) in the browser.


## Demo application
You can also try [demo app](http://fullstack-party.herokuapp.com) online.


# Great task for Great Fullstack Developer

If you found this task it means we are looking for you!

> Note: To clone this repository you will need [GIT-LFS](https://git-lfs.github.com/)

## Few simple steps

1. Fork this repo
2. Do your best
3. Prepare pull request and let us know that you are done

## Few simple requirements

- Design should be recreated as closely as possible.
- Design must be responsive. Because we live in our smartphones and we will check with them for sure.
- Use GitHub V3 REST API to receive data. [Docs here](https://developer.github.com/v3/)
- Use popular PHP framework (SlimPHP, Lumen, Symfony, Laravel, Zend or any other)
- Use AngularJS or ReactJS.
- Use CSS preprocessor (SCSS preferred).
- Browser support must be great. All modern browsers plus IE9 and above.
- Use a Javascript task-runner. Gulp, Webpack or Grunt - it doesn't matter.
- Do not commit the build, because we are building things on deployment.

## Few tips

- Structure! WE LOVE STRUCTURE!
- Maybe You have an idea how it should interact with users? Do it! Its on you!
- Have fun!
