# Using Tailwind UI

The third-generation NewMR UI is built with [Tailwind CSS](https://tailwindcss.com) and makes heavy use of components from Tailwind UI. This repository includes a local copy of the Tailwind UI kit and two full templates for reference. These resources live under the top-level `tailwindui/` directory.

## Included resources

- `tailwindui/ui-kit` – Standalone React components that can be copied into the theme or used as inspiration when creating Gutenberg blocks and other UI pieces.
- `tailwindui/templates/compass` – The "Compass" site template.
- `tailwindui/templates/keynote` – The "Keynote" site template.

Both templates are provided strictly for design inspiration. They are full Next.js sites demonstrating how the components fit together. Browse the source under their respective `src/` directories to see complete layouts, navigation patterns, and interactive widgets.

## Workflow

1. **Install theme dependencies**
   
   ```bash
   cd generations/third/newmr-theme
   npm install
   ```

2. **Run the development server**

   ```bash
   npm run watch
   ```

   This compiles the theme's assets with Vite and enables hot reloading. Edit files inside `newmr-theme` and refresh the browser to see updates.

3. **Copy components from the UI kit**

   Find a desired component in `tailwindui/ui-kit/` and copy the JSX into your plugin or theme. The components expect Tailwind CSS classes and may rely on [Headless UI](https://headlessui.dev). Install any additional npm packages as needed.

4. **Reference the templates for layout ideas**

   The Compass and Keynote templates showcase complete layouts that are very similar to what NewMR needs. Open the `README.md` inside each template for instructions on running the template locally. Studying these examples is recommended before building new pages.

## Notes

Tailwind UI is a commercial product. The files included here are licensed to NewMR and must not be redistributed. Only commit derivatives or components that fall within the license terms.
