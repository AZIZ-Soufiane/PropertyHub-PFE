/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.{blade.php,js}",
    "./app/**/*.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        // Primary: Deep Slate Blue
        primary: {
          50: '#eff3fa',
          100: '#dbe4f4',
          200: '#bdcfea',
          300: '#90addc',
          400: '#5d85c8',
          500: '#3b65ad',
          600: '#2d4f8e',
          700: '#264073',
          800: '#23385f',
          900: '#213151',
          950: '#161e33',
        },
        // Secondary: Vibrant Cyan
        secondary: {
          500: '#029fca',
          600: '#0285a3',
        },
      },
      borderRadius: {
        xl: '12px',
        '2xl': '16px',
        '3xl': '24px',
      },
      spacing: {
        'safe-top': 'max(1rem, env(safe-area-inset-top))',
        'safe-bottom': 'max(1rem, env(safe-area-inset-bottom))',
      },
      boxShadow: {
        'primary': '0 4px 15px rgba(59, 101, 173, 0.2)',
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
      },
    },
  },
  plugins: [],
}
