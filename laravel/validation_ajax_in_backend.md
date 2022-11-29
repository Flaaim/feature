## Валидация AJAX запроса в бэке.
1. Есть форма, которая отправляет ajax запрос, ее необходимо провалидировать.
```js
    $('.save').click(function(){ // нажимаем на кнопку
        let id = $(this).prop('id') //
        const data = {}; //создаем объект
        
        $('#'+id+' .data').each(function(){
            data[$(this).attr('name')] = $(this).val()
        }) //заполняем объект данными в виде {profession:'информация', harmfulfactor:'11.3'}
        $.ajax({
            url: "{{route('harmful.save')}}",
            method: "POST",
            data: {data:data},
            dataType: "json",
            success: function(data){
                console.log(data)
                $(`<div id="flashmessage" class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>`+data.message+`</strong>
                    </div>`
                ).prependTo('.col-md-10');
            }
        }) //Выполняем ajax запрос.
        }
 ```
 2. Валидация данных. Данные приходят в массиве data
 3. Создаем Request. php artisan make:request HarmfulfactorRequest.
 4. В HarmfulfactorRequest для успешной валидации данных необходимо переопределить метод validationData() из FormRequest
 ```
  //HarmfulfactorRequest
     public function validationData()
    {
        return $this->data; //data отправляем в ajax запросе
    }
 ```
5. Заполняем метод rules();
6. Также необходимо переопределить метод failedValidation(Validator $validator) из FormRequest
```
    protected function failedValidation(Validator $validator)
    {
         
        throw (new ValidationException($validator))->status(200); //возвращаем код 200
                    //->errorBag($this->errorBag)
                    //->redirectTo($this->getRedirectUrl()); 
    }
```
