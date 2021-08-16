# Vaskovsky Template Library (VTL)

HTML templates. See [html/index.html](html/index.html)

## Classes

`.A4` = `.w-A4` + `.mx-auto`

`.btn-print` prints the page on click

`.btn-reload` refreshes the page on click

`.fw-300` = `font-weight: 300`

`.fw-500` = `font-weight: 500`

`.text-shadow` adds `text-shadow`

`.w-A4` sets the maximum width = A4 (40em, cause 40em * 12pt (font-size) =
almost 17cm = 21cm (A4) -2cm left -2cm right)

`.w-min` = `width: min-content`

`.w-max` = `width: max-content`

## Files

`btn-print.js` implements `.btn-print`

`btn-reload.js` implements `.btn-reload`

`vtl.js`: all JS in one file

`vtl.css`: CSS classes

`style.css` = `vtl.css` + questionable style changes

--------------------------------------------------------------------------------
