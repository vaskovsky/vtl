# Vaskovsky Template Library (VTL)

HTML templates. See `html/README.html`

## JS API

`VTL.createView(entity: string)` creates a view for the `entity`.

`VTL.createForm(entity: string)` creates a form for the `entity`.

## CSS Classes

`.A4` = `.w-A4` + `.mx-auto`

`.A5` = `.w-A5` + `.mx-auto`

`.A6` = `.w-A6` + `.mx-auto`

`.btn-back` back to previous page on click

`.btn-print` prints the page on click

`.btn-reload` refreshes the page on click

`.form-floating-group` vertical input group for `.form-floating`

`.fw-300` = `font-weight: 300`

`.fw-500` = `font-weight: 500`

`.inner-my-0` removes the top margin of the first nested item 
and the bottom margin of the last nested item

`.text-shadow` adds `text-shadow`

`.w-A4` sets the maximum width = A4 (40em, cause 40em * 12pt (font-size) =
almost 170mm = 210mm (A4) -20mm left -20mm right)

`.w-A5` sets the maximum width = A5 (30em, cause 30em * 12pt (font-size) =
almost 128mm = 148mm (A5) -10mm left -10mm right)

`.w-A6` sets the maximum width = A6 (20em, cause 20em * 12pt (font-size) =
almost 85mm = 105mm (A6) -10mm left -10mm right)

`.w-min` = `width: min-content`

`.w-max` = `width: max-content`

## Files

`btn-back.js` implements `.btn-back`

`btn-print.js` implements `.btn-print`

`btn-reload.js` implements `.btn-reload`

`datepicker3.js` is the date picker configuration for Bootstrap 3

`framework.js` is a framework for AJAX applications

`vtl.js` is a minified version of `framework.js`. Supports all `.btn-*`

`vtl.ie6.js`: IE6 compatible version of `btn-*.js`
(uses id instead of class for `btn-back`, `btn-print`, `btn-reload`)

`vtl.css`: CSS classes

`style.css` = `vtl.css` + questionable style changes

## CDN

CSS:
```
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vtl@21.11.22/vtl.css" integrity="sha256-1692rQDIMm5kAHtcDEgieQkofWr0SpyZpIqmEzKIDF4=" crossorigin="anonymous"/>
```
or
```
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vtl@21.11.22/style.css" integrity="sha256-P+/o+QTCit9j3ARWjAn2ZG0wuqeX7DPKWMdvkM87/30=" crossorigin="anonymous"/>
```

JS:
```
<script src="https://cdn.jsdelivr.net/npm/vtl@21.11.22/vtl.js" integrity="sha256-JFk9BsFfUTZeI9L6p6c7yJFf7VBoZguVww6fnlUyJ/Q=" crossorigin="anonymous"></script>
```

--------------------------------------------------------------------------------
