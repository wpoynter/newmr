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
docker compose up assets # rebuild theme CSS on changes
```

The `assets` service uses Vite and Tailwind to watch the theme files and update
`dist/style.css` automatically.

## Porting Checklist

The rewrite is still missing several features from the second-generation code:

- Adverts widgets.
- Theme options page and Google Analytics snippet.
- Custom post sorting and share integration.

## Mobile Theme Compatibility

The plugin ships with helpers that mimic `jetpack_check_mobile()` and disable
Jetpack\'s legacy mobile theme. When the Jetpack plugin reports a mobile device
the filter `template_include` will look for `mobile.php` in the active theme and
use it if present.

1. Install and activate the Jetpack plugin.
2. (Optional) Create a `mobile.php` template inside `newmr-theme` to provide a
   simplified layout for mobile devices. If the file is missing the normal theme
   templates are used.
