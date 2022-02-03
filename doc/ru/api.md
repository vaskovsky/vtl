# VTL API

## JavaScript API

`VTL.createView(component_id: string)` создаёт представление для компонента `component_id`.
Возвращает `VTL.Promise` после успешного обнаружения компонента и загрузки данных представления.

`VTL.createForm(component_id: string)` создаёт форму для компонента `component_id`.
Возвращает `VTL.Promise` после успешного обнаружения компонента и инициализации формы.

`VTL.error(type: string, message: string, location: string)`: отображает сообщение об ошибке.

### Обработчики

`VTL.initialPOST` отправляет начальный POST со строкой запроса из URL.

`VTL.updateMathJax` обновляет представление формул при использовании MathJax.

Использование обработчиков:
```
VTL.createForm("login").then(VTL.initialPOST);
```

### VTL.Component

`new VTL.Component(id: string)` создаёт новый `VTL.Component`.

`component.id: string`: идентификатор компонента.

`component.model: XMLDocument`: модель компонента.

`component.view: HTMLElement`: вид компонента.

### VTL.Promise

`component.promise(executor)` возвращает обещание, привязанное к данному компоненту.

`executor: resolve => void` это функция, выполняемая конструктором в процессе создания нового обещания.

`resolve(status: string)` вызывает следующее в цепочке обещание, привязанное к данному компоненту.

`VTL.Promise` допускает множественный вызов `resolve` внутри функции `executor` и вложенных асинхронных функциях.
При каждом вызове `resolve` будут вызываться все последующие обещания.

`reject(reason)` не поддерживается в `VTL.Promise`. `VTL.error` используется вместо неё.

`promise.then(onFulfilled)` добавляет обработчик выполнения к обещанию и возвращает новое обещание.

`onFulfilled: component => VTL.Promise`: обработчик выполнения к обещанию обязан вернуть объект типа `VTL.Promise`.

`catch(onRejected)` не поддерживается в `VTL.Promise`. `VTL.error` используется вместо неё.

## Классы CSS

`.A4` = `.w-A4` + `.mx-auto`.

`.A5` = `.w-A5` + `.mx-auto`.

`.A6` = `.w-A6` + `.mx-auto`.

`.subquery, #subquery`: при щелчке добавляет текущую строку запроса к атрибуту `href`.

`.btn-back, #btn-back`: кнопка "Назад".

`.btn-print, #btn-print`: кнопка "Печать".

`.btn-reload, #btn-reload` кнопка "Обновить".

`.form-floating-group` вертикальная группа ввода для `.form-floating`.

`.fw-300` = `font-weight: 300`.

`.fw-500` = `font-weight: 500`.

`.inner-my-0` удаляет верхнее поле первого дочернего элемента и нижнее поле последнего дочернего элемента.

`.text-shadow` добавляет `text-shadow`.

`.w-A4` устанавливает максимальную длину = A4
(40em, потому что 40em * 12pt (размер шрифта) =
 почти 170mm = 210mm (A4) -20mm слева -20mm справа).

`.w-A5` устанавливает максимальную длину = A5
(30em, потому что 30em * 12pt (размер шрифта) =
 почти 128mm = 148mm (A5) -10mm слева -10mm справа).

`.w-A6` устанавливает максимальную длину = A6
(20em, потому что 20em * 12pt (размер шрифта) =
 почти 85mm = 105mm (A6) -10mm слева -10mm справа).

`.w-min` = `width: min-content`.

`.w-max` = `width: max-content`.

## HTML

Расположение бэкенд-сервера можно изменить с помощью HTML-тега:
```
<link id="server" href="https://vaskovsky.ru/vtl/sample/ru/" rel="preconnect"/>
```
где `https://vaskovsky.ru/vtl/sample/ru/` это адрес Вашего бэкенд-сервера.

## Файлы

`vtl.src.js`: JavaScript-фреймворк.

`vtl.js`: минимизированная версия файла `vtl.src.js`.

`vtl.css`: набор стилей CSS.

`style.css` = `vtl.css` + сомнительные изменения стилей стандартных элементов.

`markdown.css`: минимальный набор стилей для простых текстовых документов.
________________________________________________________________________________
