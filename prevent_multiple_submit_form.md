# Предотвращение нажать на кнопку отправить множество раз.
1. Создаем функцию
```js
function preventSubmit(btn) {
  btn.disabled = true;
  btn.form.submit();
}
```
2. В форме отправке button
```
<button class="btn btn-primary" type="submit" onclick="preventSubmit(this)">{{__('direction.create')}}</button>
```
