/** @type {import('tailwindcss').Config} */
export default {
  content: [ "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",],
  theme: {
    extend: {
        '44': "11rem",
    },
      spinner: (theme) =>({
          default: {
              color: '#dae1e7',
              size: '1em',
              border: '2px',
              speed: '500ms',
          }
      })
  },
  plugins: [
      require('tailwindcss-spinner')(),
  ],
}

