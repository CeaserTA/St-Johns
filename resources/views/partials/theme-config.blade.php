<script>
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        colors: {
          primary:    "#0c1b3a",  // --navy
          secondary:  "#c0392b",  // --red
          accent:     "#c8973a",  // --gold
          "accent-light": "#e8b96a",  // --gold2
          cream:      "#fdf8f0",  // --cream
          sand:       "#f5ede0",  // --sand
          muted:      "#6b7080",  // --muted
          border:     "#e2d9cc",  // --border
          success:    "#1a7a4a",  // --green
          "primary-light": "#142450", // --navy2
        },
        fontFamily: {
          display: ["Jost", "sans-serif"],
          sans:    ["Jost", "system-ui", "sans-serif"],
        },
        borderRadius: {
          lg:    "0.75rem",
          xl:    "1rem",
          "2xl": "1.5rem",
          full:  "9999px",
        },
        boxShadow: {
          card:        "0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05)",
          "card-hover":"0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04)",
        },
      },
    },
    plugins: [
      function ({ addComponents }) {
        addComponents({
          '.card-base': {
            '@apply bg-white rounded-2xl shadow-card border border-gray-100/80 overflow-hidden transition-all duration-300 ease-out': {},
          },
          '.card-hover': {
            '@apply hover:shadow-card-hover hover:-translate-y-1 hover:border-accent/30': {},
          },
          '.card-title': {
            '@apply text-xl lg:text-2xl font-bold text-primary mb-6': {},
          },
          '.card-number': {
            '@apply text-4xl lg:text-5xl font-black mt-1': {},
          },
          '.card-muted': {
            '@apply text-sm text-muted': {},
          },
          '.card-icon-container': {
            '@apply p-4 rounded-xl transition-colors': {},
          },
          '.card-icon': {
            '@apply h-8 w-8': {},
          },
        })
      }
    ]
  }
</script>