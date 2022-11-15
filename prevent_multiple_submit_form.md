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
3. Чтобы изменить текст кнопки в функции необходимо добавить
```
$(btn).html('Some text..')  //button
$(input).prop('value', 'some text..') //input
```
