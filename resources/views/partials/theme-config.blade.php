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
      },
    },
  }
</script>
