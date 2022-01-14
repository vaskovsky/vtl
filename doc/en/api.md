# VTL API

## JavaScript API

`VTL.createView(component_id: string)` creates a view for the component `component_id`.
Returns `VTL.Promise` after successfully discovering the component and loading the view data.

`VTL.createForm(component_id: string)` creates a form for the component `component_id`.
Returns `VTL.Promise` after successfully detecting the component and initializing the form.

`VTL.error(type: string, message: string, location: string)`: displays an error message.

### Handlers

`VTL.initialPOST` sends an initial POST with a query string from the URL.

`VTL.updateMathJax` updates the formula view when using MathJax.

Using handlers:
```
VTL.createForm("login").then(VTL.initialPOST);
```

### VTL.Component

`new VTL.Component(id: string)` creates a new `VTL.Component`.

`component.id: string`: component ID.

`component.model: XMLDocument`: component model.

`component.view: HTMLElement`: component view.

### VTL.Promise

`component.promise(executor)` returns a promise, bound to this component.

`executor: resolve => void` is a function, to be executed by the constructor, during the process of constructing the new promise.

`resolve(status: string)` invokes the next promise in the chain, bound to this component.

`VTL.Promise` allows multiple calls of `resolve` inside a function `executor` and nested asynchronous functions.
Every time you call `resolve` all subsequent promises will be invoked.

`reject(reason)` is not supported in `VTL.Promise`. `VTL.error` is used instead.

`promise.then(onFulfilled)` adds a fulfillment handler to the promise and returns a new promise.

`onFulfilled: component => VTL.Promise`: the fulfillment handler must return an object of type `VTL.Promise`.

`catch(onRejected)` is not supported in `VTL.Promise`. `VTL.error` is used instead.

## CSS classes

`.A4` = `.w-A4` + `.mx-auto`.

`.A5` = `.w-A5` + `.mx-auto`.

`.A6` = `.w-A6` + `.mx-auto`.

`.subquery, #subquery`: when clicked adds the current query string to the attribute `href`.

`.btn-back, #btn-back`: button "Back".

`.btn-print, #btn-print`: button "Print".

`.btn-reload, #btn-reload` button "Refresh".

`.form-floating-group` vertical input group for `.form-floating`.

`.fw-300` = `font-weight: 300`.

`.fw-500` = `font-weight: 500`.

`.inner-my-0` removes the top margin of the first child element and the bottom margin of the last child element.

`.text-shadow` adds `text-shadow`.

`.w-A4` sets the maximum length = A4
(40em, because 40em * 12pt (font size) =
 almost 170mm = 210mm (A4) -20mm left -20mm right).

`.w-A5` sets the maximum length = A5
(30em, because 30em * 12pt (font size) =
 almost 128mm = 148mm (A5) -10mm left -10mm right).

`.w-A6` sets the maximum length = A6
(20em, because 20em * 12pt (font size) =
 almost 85mm = 105mm (A6) -10mm left -10mm right).

`.w-min` = `width: min-content`.

`.w-max` = `width: max-content`.

## HTML

The location of the backend server can be changed using the HTML tag:
```
<link id="server" href="http://vaskovsky.net/vtl/sample/en/" rel="preconnect"/>
```
where `http://vaskovsky.net/vtl/sample/en/` is the address of your backend server.

## Files

`btn-back.js` implements `.btn-back, #btn-back` without framework.

`btn-print.js` implements `.btn-print, #btn-print` without framework.

`btn-reload.js` implements `.btn-reload, #btn-print` without framework.

`datepicker3.js`: date picker for Bootstrap 3.

`framework.js`: JavaScript framework.

`vtl.js`: minimized version of the file `framework.js`.

`vtl.ie6.js`: IE6-compatible implementation for `btn-*`
(uses `id` instead of classes).

`vtl.css`: CSS style set.

`style.css` = `vtl.css` + questionable changes to the styles of standard elements.

`markdown.css`: minimum set of styles for simple text documents.
________________________________________________________________________________
[↩ Back](javascript:history.back();)
