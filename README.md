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

## Tests and Linting

Once scripts are available, use the following commands:

```bash
npm run lint   # Check code style
npm test       # Run unit tests
```

