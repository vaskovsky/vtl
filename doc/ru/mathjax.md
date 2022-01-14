# MathJax

MathJax &#8212; это библиотека для отображения математических формул <https://www.mathjax.org/>.

[Синтаксис формул](mathjax.syntax.md)

## CDN

```
<script src="https://cdn.jsdelivr.net/npm/mathjax@3.2.0/es5/tex-chtml.js" integrity="sha256-z47L98YXVhVIaY0uyDzt675P5Ea+w3RsPh9VD5NuoTY=" crossorigin="anonymous"></script>
```

## Использование MathJax с VTL

`VTL.updateMathJax` обновляет представление формул при использовании MathJax.

Например,
```
VTL.createView(component_id).then(VTL.updateMathJax);
```
________________________________________________________________________________
