# Проверка тестовых сценариев

### Представление результатов

Предоставление результатов требуется описать в следующем виде:

1. Идентификатор
2. Назначение / название
3. Сценарий
4. Ожидаемый результат
5. Фактический результат (заполняется на этапе тестирования)
6. Оценка (заполняется на этапе тестирования)

Тестовые сценарии:

#### Регистрация пользователя в системе.

1. 001
2. Регистрация
3. Произведите следующие шаги:
   1. Открыть любую страницу сайта
   2. Если пользователь не авторизован, тогда нажать на кнопку "Registration"
   3. Если пользователь авторизован, тогда выйти из аккаунта с помощью кнопки "Exit"
   5. Открывается форма для регистрации
   6. Ввести данные пользователя: Фамилию, Имя, e-mail, пароль
   7. Нажать на кнопку "Регистрация"
   8. В случае, если данные были введены не верно(Система должна описать где вы совершили ошибку) повторить пункты 6,7.
4. В базе данных сайта сохранился новый пользователь 
5. Зарегистрирован новый пользователь
6. Выполнен

#### Авторизация пользователя в системе.

1. 002
2. Авторизация.
3. Произведите следующие шаги:
   1. Открыть любую страницу сайта
   2. Нажмите на кнопку "Вход"
   3. Появляется форма для авторизации
   4. Ввод логина и пароля и нажатие чекбокса "Запомнить меня" при желании оставаться в аккаунте после закрытия браузера
   5. Нажать на кнопку "Вход"
   6. В случае, если данные были введены не верно(Система должна описать где вы совершили ошибку) повторить пункты 4,5
4. При нажатии на кнопку "Вход" и ввод достоверных данных и нажатии кнопки "Вход" происходит авторизация пользователя.
5. Пользователь авторизован.
6. Выполнен.

#### Выбор игры пользователем.

1. 003
2. Выбор игры.
3. Произведите следующие шаги:
   1. Если вы не на главной странице, нажать на кнопку "To the main menu".
   2. На главной странице выбираем игру, нажимая на статические изображения, с лейблами, определяющими сылки на какую игру содержит изображение, либо выбрать игру на слайд-шоу.
4. Переход на страницу с выбранной игрой.
5. Возможность играть в выбранную игру.
6. Выполнен.

#### Прохождение игры 2048 с потенциальной возможностью одержать победу.

1. 004
2. Прохождение игры 2048.
3. Произведите следующие шаги:
   1. Откройте страницу сайта с игрой 2048(см. сценарий 003).
   2. Выбираем количество ячеек игры.
   3. Нажимая клавиши W S D A управляем течением игры.
   4. В случае проигрыша, т.е. если доступных ходов нет, необходимо начать заново, нажав на кнопку OK.
   5. Победа: окно информирования о победе.
4. Вывод окна, информирующего о победе.
5. Одержание победы или проигрыша. В обоих случаях, вывод информации об выйгрыше/проигрыше.
6. Выполнен.

#### Прохождение игры Сапер с потенциальной возможностью одержать победу.

1. 005
2. Прохождение игры Сапер
3. Произведите следующие шаги:
   1. Откройте страницу сайта с игрой Саппер(см. сценарий 003)
   2. Выбираем сложность игры
   3. Кликая по ячейкам правой либо левой клавишей мыши, в зависимости от необходимости(левая кнопка миши - предположение о том, что в ней нет бомбы, правая кнопка мыши - постановка/снятие флажка)
   4. В случае проигрыша, т.е. если в ячейке, при нажатии на левую кнопку мыши была обнаружена бомба, существует возможность начать заново, кликнув на надписть "Try Again"
   5. Победа: появление надписи о количестве секунд, потребовавшихся на данную сессию игры
4. Появление надписи о количестве секунд, потребовавшихся на данную сессию игры
5. Одержание победы или проигрыша. В обоих случаях, вывод информации об выйгрыше/проигрыше
6. Выполнен

#### Сохранение статистики (количество побед, поражений) для зарегистрированных пользователей.

1. 006
2. Сохранение статистики
3. Произведите следующие шаги:
   1. Открыть любую страницу сайта
   2. Если пользователь не авторизован, тогда авторизоваться или пройти регистрацию на сайте
   3. Если пользователь авторизован, зайти на страницу с любой из игр
   4. После одержание победы/поражение инкремент столбца победы/поражения таблице, соответствующего данной игре
   5. При наведение на лейбл Score, который отображается только для зарегестрированного пользователя, просмотр обновленной статистики
4. Изменение столбцов таблицы в соответствии с результатом игры
5. При наведение на Score отображается уже обновленная статистика
6. Выполнен

#### Отображение статистики для зарегестрированных пользователей.

1. 007
2. Отображение статистики
3. Произведите следующие шаги:
   1. Открыть любую страницу сайта
   2. Если пользователь не авторизован, тогда авторизоваться или пройти регистрацию на сайте
   3. Если пользователь авторизован, зайти на страницу с любой из игр
   4. Если регистрация прошла успешна, в голове страницы будет отображаться лейбл Score
   5. При наведение на лейбл Score будет произведено считывание данных из бд и отображение их на выпыплывающую форму
4. Просмотр статистики игр пользователем
5. Вывод на форму текущей статистики игр
6. Выполнен


Данные тесты показывают выполнение функциональных требований. Соответствие функциональных требований и тестов:

| Функциональные требования                | ID теста | Успешнось выполнения тестов, % |
| ---------------------------------------- | :------: | :----------------------------: |
| Регистрация пользователя в системе		           |    001    |  90  | 
| Авторизация пользователя в системе                 |    002    |  90  |
| Выбор игры пользователем                |    003    |  100  |
| Прохождение игры 2048 с потенциальной возможностью одержать победу                 |    004    |  100  |
| Прохождение игры Саппер с потенциальной возможностью одержать победу               |    005    |  100 |
| Сохранение статистики (количество побед, поражений) для зарегистрированных пользователей |    006   | 100 |
| Отображение статистики для зарегестрированных пользователей               |    007    |  100  |

Видно, что все практически все функциональные требования выполняется на все 100%. Есть некоторые недочеты по Авторизации и Регистрации.
