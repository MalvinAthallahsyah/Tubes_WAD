// tailwind.config.js
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        poppins: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'], // ✅ updated
      },
      colors: {
        brand: {
          DEFAULT: '#d32f2f',
          hover: '#b71c1c',
        },
        base: '#f9fafb',
        text: '#374151',
      },
    },
  },
  plugins: [],
}
