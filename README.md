# NewMR WordPress Toolkit

This repository hosts the NewMR WordPress theme and plugin code. The long-term goal is to build a **third-generation** codebase that will replace the existing second-generation version currently stored under `generations/second/`.

## Repository Structure

- `generations/second/` – The legacy WordPress theme and plugin.
- `generations/third/` – The in-progress rewrite for the next major generation.

## Contributing

Please read `AGENTS.md` for important contribution rules and coding guidelines.

## Quick Start with Docker

A Docker configuration is provided to spin up a local WordPress environment. Ensure you have Docker installed, then run:

```bash
docker compose up -d
```

WordPress will be available at [http://localhost:8000](http://localhost:8000). Theme files from `generations/third/` will be mounted automatically.

## Tests and Linting

Once scripts are available, use the following commands:

```bash
npm run lint   # Check code style
npm test       # Run unit tests
```

