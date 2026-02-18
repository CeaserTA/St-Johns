<script>
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        colors: {
          // Exact colours taken directly from your "Logo Final.png"
          primary:   "#0A2463",  // Deep Navy Blue (shield, cross, main text)
          secondary: "#A5282C",  // Sacred Liturgical Red (red edges of the open Bible – perfect!)
          accent:    "#D4AF37",  // Rich Gold (crown, cross outline, shield border)

          // Backgrounds & text – clean and modern
          "background-light": "#F8F7F2",  // Warm cream straight from your logo background
          "background-dark":  "#101922",  // Deep navy-black for future dark mode

          "text-light":       "#111418",  // Near-black for light mode
          "text-muted-light": "#6B7280",  // Soft neutral gray (better than old muted blue)

          "text-dark":        "#F8F7F2",  // Cream-white for dark mode text
          "text-muted-dark":  "#9CA3AF",  // Light gray for dark mode muted text
        },
        fontFamily: {
          display: ["Manrope", "sans-serif"],  // Manrope = more elegant & church-appropriate than Inter
          sans:    ["Manrope", "system-ui", "sans-serif"]
        },
        borderRadius: {
          lg: "0.75rem",
          xl: "1rem",
          "2xl": "1.5rem",
          full: "9999px"
        },
        
             // NEW: Reusable card styles
        boxShadow: {
          card: '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
          'card-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
        },
      },
    },
    plugins: [
      function ({ addComponents }) {
        addComponents({
          '.card-base': {
            '@apply bg-white dark:bg-background-dark rounded-2xl shadow-card border border-gray-100/80 dark:border-gray-700 overflow-hidden transition-all duration-300 ease-out': {},
          },
          '.card-hover': {
            '@apply hover:shadow-card-hover hover:-translate-y-1 hover:border-accent/30 dark:hover:border-accent/50': {},
          },
          '.card-title': {
            '@apply text-xl lg:text-2xl font-bold text-primary dark:text-text-dark mb-6': {},
          },
          '.card-number': {
            '@apply text-4xl lg:text-5xl font-black mt-1': {},
          },
          '.card-muted': {
            '@apply text-sm text-gray-500 dark:text-text-muted-dark': {},
          },
          '.card-icon-container': {
            '@apply p-4 rounded-xl transition-colors': {},
          },
          '.card-icon': {
            '@apply h-8 w-8': {},
          }
        })
      }
    ]
  }
</script>

