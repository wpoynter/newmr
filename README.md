# NewMR WordPress Toolkit

This repository hosts the NewMR WordPress theme and plugin code. The long-term goal is to build a **third-generation** codebase that will replace the existing second-generation version currently stored under `generations/second/`.

## Repository Structure

- `generations/second/` – The legacy WordPress theme and plugin.
- `generations/third/` – The in-progress rewrite for the next major generation.

## Contributing

Please read `AGENTS.md` for important contribution rules and coding guidelines.

## Quick Start with Docker

A `docker-compose.yml` file is provided to launch WordPress with the third generation code mounted as a theme and plugin. After installing Docker, start the containers with:

```bash
docker compose up
```

Navigate to [http://localhost:8000](http://localhost:8000) to access the site. Any changes made inside `generations/third/newmr-theme` or `generations/third/newmr-plugin` will be reflected immediately.

## Building the Theme
Run `npm install` inside `generations/third/newmr-theme` and then `npm run build` to compile the Tailwind styles with Vite. Use `npm run watch` during development. The compiled CSS in `dist/style.css` is excluded from version control.

## Tailwind UI Resources
The repository includes a licensed copy of [Tailwind UI](https://tailwindui.com) under the `tailwindui/` directory. These components and templates are used for the third-generation UI. See `generations/third/TailwindUI.md` for usage instructions.


## Tests and Linting

Run the following commands before committing:

```bash
composer test  # Run PHPCS and PHPUnit tests
npm run lint   # Check code style
npm test       # Run unit tests
```

