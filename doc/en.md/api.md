# VTL API

## JavaScript API

`VTL.createView(component_id: string)` creates a view for the component `component_id`

`VTL.createForm(component_id: string)` creates a form for the component `component_id`

## HTML templates

See [html/README.html](html/README.html)

## CSS classes

`.A4` = `.w-A4` + `.mx-auto`

`.A5` = `.w-A5` + `.mx-auto`

`.A6` = `.w-A6` + `.mx-auto`

`.btn-back, #btn-back`: button "Back"

`.btn-print, #btn-print`: button "Print"

`.btn-reload, #btn-reload` button "Refresh"

`.form-floating-group` vertical input group for `.form-floating`

`.fw-300` = `font-weight: 300`

`.fw-500` = `font-weight: 500`

`.inner-my-0` removes the top margin of the first child element and the bottom margin of the last child element

`.text-shadow` adds `text-shadow`

`.w-A4` sets the maximum length = A4 (40em, because 40em * 12pt (font size) =
almost 170mm = 210mm (A4) -20mm left -20mm right)

`.w-A5` sets the maximum length = A5 (30em, because 30em * 12pt (font size) =
almost 128mm = 148mm (A5) -10mm left -10mm right)

`.w-A6` sets the maximum length = A6 (20em, because 20em * 12pt (font size) =
almost 85mm = 105mm (A6) -10mm left -10mm right)

`.w-min` = `width: min-content`

`.w-max` = `width: max-content`

## Files

`btn-back.js` implements `.btn-back, #btn-back` without framework

`btn-print.js` implements `.btn-print, #btn-print` without framework

`btn-reload.js` implements `.btn-reload, #btn-print` without framework

`datepicker3.js`: date picker for Bootstrap 3

`framework.js`: JavaScript framework

`vtl.js`: minimized version of the file `framework.js`

`vtl.ie6.js`: IE6-compatible implementation for `btn-*`
(uses `id` instead of classes)

`vtl.css`: CSS style set

`style.css` = `vtl.css` + questionable changes to the styles of standard elements

`markdown.css`: minimum set of styles for simple text documents
________________________________________________________________________________
[&#8617; Vaskovsky Template Library (VTL)](index.md)
