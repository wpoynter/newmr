# Third Generation

This folder contains the in-progress rewrite of the NewMR WordPress toolkit. All theme and plugin development for the upcoming release happens here.

## Tailwind UI

The UI for this generation is being built with Tailwind CSS. A licensed copy of Tailwind UI is included under `../../tailwindui/` for convenience. See [TailwindUI.md](./TailwindUI.md) for details on how to browse and reuse these components and templates.

## Getting Started

Use the root `docker-compose.yml` file to spin up a development site:

```bash
docker compose up -d
composer install
npm install --prefix newmr-theme
docker compose run --rm tests composer test
# Running the tests via Docker ensures consistent PHP and MySQL versions
npm run --prefix newmr-theme build
```

The theme assets can be rebuilt during development with `npm run --prefix newmr-theme watch`.

## Porting Checklist

The rewrite is still missing several features from the second-generation code:

- Adverts widgets.
- Theme options page and Google Analytics snippet.
- Custom post sorting and share integration.
- Jetpack/mobile theme compatibility.
