### Обновление данных SELECT + UPDATE
в одну строку
```mysql
UPDATE article_clone SET likes = (@cur_value := likes) + 1 WHERE id = 1
```

```mysql

//SQL манипулирование данными

SELECT * FROM city; //Выбор всех данных

SELECT * FROM city LIMIT 10; //тоже самое + ограничение на 10 строк

SELECT * FROM city ORDER BY name; //выбор всех данных с сортировкой по столбцу name

SELECT * FROM city ORDER BY id DESC; //выбор всех данных с сортировкой по столбцу id по убыванию

SELECT id, name, population FROM city WHERE population BETWEEN 5000000 AND 6500000; //выбор всех городов с популяцией в диапозоне от 5000000 до 6500000
SELECT id, name, population FROM city WHERE population > 5000000 AND population < 6500000; 

SELECT countrycode, COUNT(countrycode) FROM city GROUP BY countrycode; //выбрать количество городов каждой из стран

SELECT countrycode, COUNT(countrycode) FROM city GROUP BY countrycode HAVING countrycode 'USA'; //выбрать количество городов в конкретной стране

SELECT SUM(population) FROM country; //сложить все данные

SELECT Governmentform, COUNT(Governmentform) FROM country GROUP BY Governmentform; //сгруппировать все данные по форме правления и количество стран по каждой из форм.
```
