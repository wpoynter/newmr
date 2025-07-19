# Contribution Guidelines

This repository hosts multiple generations of the NewMR codebase.

## Repository layout
- `generations/second/` contains the previous generation of code. Treat it as **read-only** reference.
- `generations/third/` is the home for all new development. Add new plugins, themes, and scripts here.

## Coding style
- **PHP**: follow the [WordPress coding standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/). Use `composer lint` to check your code.
- **JavaScript/CSS**: format using Prettier. Run `npm run lint` (or `npx prettier --check .`) before committing.

## Commit and PR guidelines
- Keep commits focused: one logical change per commit.
- Run linters and tests prior to committing:
  - `composer test`
  - `npm test`
  - `npm run lint`
- Ensure all checks pass before opening a pull request.

## Local Development with Docker

Run the provided Docker Compose configuration to start WordPress with the third-generation theme and plugin mounted:

```bash
docker compose up
```

