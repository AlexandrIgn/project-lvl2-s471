[![Build Status](https://travis-ci.org/AlexandrIgn/project-lvl2-s471.svg?branch=master)](https://travis-ci.org/AlexandrIgn/project-lvl2-s471)

[![Maintainability](https://api.codeclimate.com/v1/badges/2139ef86fbd7c433911a/maintainability)](https://codeclimate.com/github/AlexandrIgn/project-lvl2-s471/maintainability)
# Вычислитель отличий <h2> 
Данный проект реализован в рамках учебной программы на портале [Хеклет](https://ru.hexlet.io/pages/about). В рамках проекта реализована программа для поиска и вывода отличий между двумя файлами форматов json или yml. Программа позволяет выводить информацию в различном виде. 
Для получения результата необходимо передать пути до двух файлов:
``
gendiff before.json after.json
``
Работа программы по-умолчанию
![vlojenniydif](https://user-images.githubusercontent.com/46720922/64365615-9e513400-d025-11e9-8381-2bc45494aacf.gif)
Для получения результата в формате plain:
``
gendiff before.json after.json --format plain
``
Вывод информации в формате plain
![plain](https://user-images.githubusercontent.com/46720922/64365658-b032d700-d025-11e9-99dd-0a4f02fca4e1.gif)
Для получения результата в формате json:
``
gendiff before.json after.json --format json
``
Вывод информации в формате json
![Peek 2019-09-05 21-38](https://user-images.githubusercontent.com/46720922/64365706-c476d400-d025-11e9-81c1-6af3e1471266.gif)

