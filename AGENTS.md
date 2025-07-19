# Contribution Guidelines

This repository hosts multiple generations of the NewMR codebase.

## Repository layout
- `generations/second/` contains the previous generation of code. Treat it as **read-only** reference.
- `generations/third/` is the home for all new development. Add new plugins, themes, and scripts here.

## Coding style
- **PHP**: follow the [WordPress coding standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/). Run `composer lint` or `composer test` to check your code with PHPCS.
- **JavaScript/CSS**: format using Prettier. Run `npm run lint` (or `npx prettier --check .`) before committing.

### Building the theme
Run `npm install` in `generations/third/newmr-theme` once. Use `npm run build` to compile assets and `npm run watch` for development.


## Commit and PR guidelines
- Keep commits focused: one logical change per commit.
- Run linters and tests prior to committing:
  - `composer test` (runs PHPCS)
  - `npm test`
  - `npm run lint`
- Ensure all checks pass before opening a pull request.

## Local Development with Docker

Run the provided Docker Compose configuration to start WordPress with the third-generation theme and plugin mounted:

```bash
docker compose up
```

## End-to-End Tests

Basic tests live under `e2e/` and expect the Docker environment to be running.
Start the containers and then execute the tests from the theme directory:

```bash
docker compose up -d
cd generations/third/newmr-theme
npm run e2e
```

Set `BASE_URL` if the site is accessible at a different address.

