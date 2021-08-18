# Vaskovsky Template Library (VTL)

HTML templates. See `html/README.html`

## Classes

`.A4` = `.w-A4` + `.mx-auto`

`.A5` = `.w-A5` + `.mx-auto`

`.A6` = `.w-A6` + `.mx-auto`

`.btn-print` prints the page on click

`.btn-reload` refreshes the page on click

`.form-floating-group` vertical input group for `.form-floating`

`.fw-300` = `font-weight: 300`

`.fw-500` = `font-weight: 500`

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

`btn-print.js` implements `.btn-print`

`btn-reload.js` implements `.btn-reload`

`vtl.js`: all JS in one file

`vtl.css`: CSS classes

`style.css` = `vtl.css` + questionable style changes

## CDN

CSS:
```
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vtl@21.8.18/vtl.css" integrity="sha256-RGFplJfLoo/ex5CFZlCfM4uaIZsG77c2wl6Codgm4bA=" crossorigin="anonymous"/>
```
or
```
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vtl@21.8.18/style.css" integrity="sha256-ege8EqBnNkCJlLMRpIk7r9i/QAuORB0sQuz3szCWEGs=" crossorigin="anonymous"/>
```

JS:
```
<script src="https://cdn.jsdelivr.net/npm/vtl@21.8.18/vtl.js" integrity="sha256-03d6QBVCar3TIv6/vJHql0Advy5D7+mL091/xSscjHE=" crossorigin="anonymous"></script>
```

--------------------------------------------------------------------------------
