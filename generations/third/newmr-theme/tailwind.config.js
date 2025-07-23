module.exports = {
  content: [
    './templates/**/*.{html,php}',
    './*.php',
    '../newmr-plugin/**/*.php',
  ],
  safelist: ['hidden', 'block', 'sm:hidden', 'sm:flex'],
  theme: {
    extend: {},
  },
  plugins: [],
};
