# MathJax

MathJax &#8212; это библиотека для отображения математических формул <https://www.mathjax.org/>.

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

## Использование MathJax

`\(x^2, x^{a+b}\)`: \\(x^2, x^{a+b}\\)

`\(x_i, x_{i+1}\)`: \\(x_i, x_{i+1}\\)

`\(A \cdot B \times C\)`:  \\(A \cdot B \times C\\)

`\(A \gt B \lt C \ge D \le E = F \ne G \approx H\)`:
\\(A \gt B \lt C \ge D \le E = F \ne G \approx H\\)

`\(\frac 1 2 x, \frac {2x} {1 - \frac 1 {x^2}}\)`:
\\(\frac 1 2 x, \frac {2x} {1 - \frac 1 {x^2}}\\)

`\(\sqrt{x} + \sqrt[3]{\log_{10}{x}}\)`: \\(\sqrt{x} + \sqrt\[3\]{\log_{10}{x}}\\)

`\(\lim_{n \to \infty} \sum_{k=1}^n \frac{1}{k}\)`:
\\(\lim_{n \to \infty} \sum_{k=1}^n \frac{1}{k}\\)

`\(\forall k\ge0 \quad \exists n \Leftrightarrow y\notin X\)`:
\\(\forall k\ge0 \quad \exists n \Leftrightarrow y\notin X\\)

`\(\angle ABC = 90^{\circ} \Longleftarrow AB \perp BC\)`:
\\(\angle ABC = 90^{\circ} \Longleftarrow AB \perp BC\\)

`\[\int\limits_a^b f(x)\,dx \ne \iint \cos{z}\,dxdy\]`:
\\[\int\limits_a^b f(x)\,dx \ne \iint \cos{z}\,dxdy\\]

`\[\begin{cases} x + 5y = 7 \\ 3x − 2y = 4 \end{cases}\]`:
\\[\begin{cases} x + 5y = 7 \\\\ 3x − 2y = 4 \end{cases}\\]
________________________________________________________________________________
[↩ VTL](index.md)
<script src="https://cdn.jsdelivr.net/npm/mathjax@3.2.0/es5/tex-chtml.js" integrity="sha256-z47L98YXVhVIaY0uyDzt675P5Ea+w3RsPh9VD5NuoTY=" crossorigin="anonymous"></script>
