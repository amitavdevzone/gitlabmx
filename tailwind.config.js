/** @type {import('tailwindcss').Config} */
export default {
  content: [
      "./resources/**/*.blade.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [
      require("daisyui")
  ],
  daisyui: {
    themes: ["light", "dark", "cupcake", "cyberpunk"],
  },
}

