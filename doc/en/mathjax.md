# MathJax

MathJax &#8212; is a JavaScript display engine for mathematics <https://www.mathjax.org/>.

[Formula Syntax](mathjax.syntax.md)

## CDN

```
<script src="https://cdn.jsdelivr.net/npm/mathjax@3.2.0/es5/tex-chtml.js" integrity="sha256-z47L98YXVhVIaY0uyDzt675P5Ea+w3RsPh9VD5NuoTY=" crossorigin="anonymous"></script>
```

## Using MathJax with VTL

`VTL.updateMathJax` updates the formula view when using MathJax.

For example,
```
VTL.createView(component_id).then(VTL.updateMathJax);
```
________________________________________________________________________________
