# VTL API

## JavaScript API

`VTL.createView(component_id: string)`
создаёт представление для компонента `component_id`.
Возвращает Promise, возвращающий `VTL.Component`.
после успешного обнаружения компонента и загрузки данных представления.

`VTL.createForm(component_id: string)`
создаёт форму для компонента `component_id`.
Возвращает Promise, возвращающий `VTL.Component`
после успешного обнаружения компонента и инициализации формы.

### Обработчики

`VTL.initialPOST` отправляет начальный POST со строкой запроса из URL.

`VTL.updateMathJax` обновляет представление формул при использовании MathJax.

Использование обработчиков:
```
VTL.createForm("login").then(VTL.initialPOST);
```

## Классы CSS

`.A4` = `.w-A4` + `.mx-auto`

`.A5` = `.w-A5` + `.mx-auto`

`.A6` = `.w-A6` + `.mx-auto`

`.btn-back, #btn-back`: кнопка "Назад"

`.btn-print, #btn-print`: кнопка "Печать"

`.btn-reload, #btn-reload` кнопка "Обновить"

`.form-floating-group` вертикальная группа ввода для `.form-floating`

`.fw-300` = `font-weight: 300`

`.fw-500` = `font-weight: 500`

`.inner-my-0` удаляет верхнее поле первого дочернего элемента и нижнее поле последнего дочернего элемента

`.text-shadow` добавляет `text-shadow`

`.w-A4` устанавливает максимальную длину = A4 (40em, потому что 40em * 12pt (размер шрифта) =
почти 170mm = 210mm (A4) -20mm слева -20mm справа)

`.w-A5` устанавливает максимальную длину = A5 (30em, потому что 30em * 12pt (размер шрифта) =
почти 128mm = 148mm (A5) -10mm слева -10mm справа)

`.w-A6` устанавливает максимальную длину = A6 (20em, потому что 20em * 12pt (размер шрифта) =
почти 85mm = 105mm (A6) -10mm слева -10mm справа)

`.w-min` = `width: min-content`

`.w-max` = `width: max-content`

## HTML

Расположение бэкенд-сервера можно изменить с помощью HTML-тега:
```
<link id="server" href="http://vaskovsky.ru/vtl/sample/ru/" rel="preconnect"/>
```
где `http://vaskovsky.ru/vtl/sample/ru/` это адрес Вашего бэкенд-сервера.

## Файлы

`btn-back.js` реализует `.btn-back, #btn-back` без фреймворка

`btn-print.js` реализует `.btn-print, #btn-print` без фреймворка

`btn-reload.js` реализует `.btn-reload, #btn-print` без фреймворка

`datepicker3.js`: выбор даты для Bootstrap 3

`framework.js`: JavaScript-фреймворк

`vtl.js`: минимизированная версия файла `framework.js`

`vtl.ie6.js`: совместимая с IE6 реализация кнопок `btn-*`
(использует `id` вместо классов)

`vtl.css`: набор стилей CSS

`style.css` = `vtl.css` + сомнительные изменения стилей стандартных элементов

`markdown.css`: минимальный набор стилей для простых текстовых документов
________________________________________________________________________________
[↩ VTL](index.md)
