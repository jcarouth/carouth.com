module.exports = {
  future: {
    removeDeprecatedGapUtilities: true,
  },
  purge: {
    content: [
      'source/**/*.html',
      'source/**/*.md',
      'source/**/*.js',
      'source/**/*.php',
      'source/**/*.vue',
    ],
    options: {
      whitelist: [
        /language/,
        /hljs/,
        /mce/,
      ],
    },
  },
  theme: {
    extend: {
      colors: {
        'dark-cerulean': '#083d77',
        'maastrict-blue': '#011627',
        'rifle-green': '#41463d',
        'platinum': '#dfe0e2',
        'light-gray': '#d0ccd0',
        'ghost-white': '#fbfcff',
        'mummys-tomb': '#7e9181',
        'medium-turquoise': '#41d38d',
        'smoky-black': '#090c08',
        'mac-orange': '#f2994a',
      },
      fontFamily: {
        sans: ['Montserrat', '"Helvetica Neue"', 'Arial', 'sans-serif'],
        serif: ['"Source Serif Pro"','Georgia', 'serif'],
        mono: ['Menlo', 'Monaco', 'Consolas', 'monospace'],
      },
      lineHeight: {
        normal: '1.6',
        loose: '1.75',
      },
      maxWidth: {
        none: 'none',
        '7xl': '80rem',
        '8xl': '88rem'
      },
      spacing: {
        '7': '1.75rem',
        '9': '2.25rem'
      },
      boxShadow: {
        'lg': '0 -1px 27px 0 rgba(0, 0, 0, 0.04), 0 4px 15px 0 rgba(0, 0, 0, 0.08)',
      }
    },
    fontSize: {
      'xs': '.8rem',
      'sm': '.925rem',
      'base': '1rem',
      'lg': '1.125rem',
      'xl': '1.25rem',
      '2xl': '1.5rem',
      '3xl': '1.75rem',
      '4xl': '2.125rem',
      '5xl': '2.625rem',
      '6xl': '10rem',
    },
  },
  variants: {
    borderRadius: ['responsive', 'focus'],
    borderWidth: ['responsive', 'active', 'focus'],
    width: ['responsive', 'focus']
  },
  plugins: [
    function({ addUtilities }) {
      const newUtilities = {
        '.transition-fast': {
          transition: 'all .2s ease-out',
        },
        '.transition': {
          transition: 'all .5s ease-out',
        },
      }
      addUtilities(newUtilities)
    }
  ]
}
