# NewMR WordPress Toolkit

This repository hosts the NewMR WordPress theme and plugin code. The long-term goal is to build a **third-generation** codebase that will replace the existing second-generation version currently stored under `generations/second/`.

## Repository Structure

- `generations/second/` – The legacy WordPress theme and plugin.
- `generations/third/` – The in-progress rewrite for the next major generation.

## Contributing

Please read `AGENTS.md` for important contribution rules and coding guidelines.

## Quick Start with Docker

A `docker-compose.yml` file is provided to launch WordPress with the third generation code mounted as a theme and plugin. After installing Docker, run:

```bash
docker compose up -d
```

Once the containers are running open [http://localhost:8000](http://localhost:8000) in your browser. Any changes made inside `generations/third/newmr-theme` or `generations/third/newmr-plugin` will be reflected immediately.

### Local setup steps

```bash
# Start Docker and install dependencies
docker compose up -d
composer install
npm install --prefix generations/third/newmr-theme

# Run the test suite
docker compose run --rm tests composer test
# Running the tests via Docker ensures consistent PHP and MySQL versions

# Build the theme assets
npm run --prefix generations/third/newmr-theme build

# (Optional) Import production content and uploads
scripts/pull-production-data.sh
```

The `pull-production-data.sh` helper expects environment variables such as
`PROD_HOST`, `PROD_DB_NAME`, and `PROD_WP_PATH`. It uses SSH to dump the
production database and sync the `wp-content/uploads` directory.

## Automated Setup

Use `scripts/set-newmr-options.sh` to configure the NewMR options via WP-CLI.
Set the following environment variables before running the script:

- `DONATE_BOX_HTML` – HTML for the Donate widget
- `ABOUT_BOX_HTML` – HTML for the About widget
- `GA_CODE` – Google Analytics tracking ID
- `LEFT_PAGE_SLUG` – Slug for the left footer link
- `RIGHT_PAGE_SLUG` – Slug for the right footer link
- `FEATURED_VIDEO_SLUG` – Slug for the featured video page

Run the script inside the `wpcli` container:

```bash
docker compose run --rm wpcli scripts/set-newmr-options.sh
```

The command is idempotent; running it multiple times will update the same
options without creating duplicates.

## Building the Theme
Run `npm install` inside `generations/third/newmr-theme` and then `npm run build` to compile the Tailwind styles with Vite. During development start the `assets` service with `docker compose up assets` to automatically rebuild the CSS when files change. The compiled CSS in `dist/style.css` is excluded from version control.

## Tailwind UI Resources
The repository includes a licensed copy of [Tailwind UI](https://tailwindui.com) under the `tailwindui/` directory. These components and templates are used for the third-generation UI. See `generations/third/TailwindUI.md` for usage instructions.


## Tests and Linting

Run the following commands before committing:

```bash
docker compose run --rm tests composer test  # Sets up tests/wordpress and runs PHPUnit
# Running the tests via Docker ensures consistent PHP and MySQL versions
npm run lint   # Check code style
```

JavaScript unit tests have not been set up yet.

## Porting Checklist

Work to migrate functionality from the second-generation code is ongoing.
The following features still need to be ported:

- Adverts widgets used in the legacy theme.
- Theme settings page including Google Analytics support.
- Sorting rules for custom post type archives.
- Jetpack/mobile theme integration and share button logic.

