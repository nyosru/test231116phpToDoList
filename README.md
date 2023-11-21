# тест задание 

Необходимо создать приложение-задачник (ToDo list).  
Фреймворки PHP использовать нельзя, библиотеки можно. Сложная архитектура не нужна.
В приложении нужно с помощью чистого PHP реализовать модель MVC. Решите поставленные задачи минимально необходимым 
количеством кода.  
Верстка на bootstrap, к дизайну особых требований нет.

Задачи состоят из:
- имени пользователя;
- е-mail;
- текста задачи;

Стартовая страница - список задач с возможностью сортировки по имени пользователя, email и статусу.
- Вывод задач нужно сделать страницами по 3 штуки (с пагинацией).
- Видеть список задач и создавать новые может любой посетитель без авторизации.

Сделайте вход для администратора (логин "admin", пароль "123").
- Администратор имеет возможность редактировать текст задачи и поставить галочку о выполнении.
- Выполненные задачи в общем списке выводятся с соответствующей отметкой.

Требования к коду: https://beejee.ru/coding-challenge-requirements
Пожалуйста, протестируйте приложение по сценарию перед сдачей. 
Если какие-то пункты не работают, я не смогу передать тестовое дальше в техотдел.

Результат нужно развернуть на любом бесплатном хостинге, 
чтобы можно было посмотреть его в действии. 
Можно запустить локально, и прислать IP-адрес (убедитесь, что приложение запускается по внешнему IP).  
Код можно выложить на github или bitbucket.

По окончанию выполнения жду две ссылки: на репозиторий, где выложен код, и на рабочее тестовое задание. 
Также, пожалуйста, укажите общее количество потраченного времени.
Если не смогли выполнить тестовое по любым причинам, пожалуйста, сообщите.

Если появились вопросы, пишите, с радостью отвечу. Хорошего дня!


# требования к коду 


Требования к коду

Суть этого тестового - решить поставленную задачу минимально необходимым набором сущностей. Вам не нужно писать собственный фреймворк. Чересчур сложная архитектура не приветствуется, хотя и не штрафуется. Фактически, хватит пары контроллеров, одной модели (Task или ToDoItem. При желании можно также заявить User), нескольких шаблонов и роутера.

    Аккуратность кода - это важно. Убедитесь, что в нем не осталось мусора, отладочных инструкций, закомментированного кода.
    Называйте переменные и объекты, чтобы по одному названию был понятен их тип и предназначение.

    См. Стив Макконнелл "Совершенный Код" (глава 11): Ссылка на книгу
    Должны быть заявлены основные элементы MVC (Model, View, Controller). Количество моделей = количеству логических сущностей.
    Обращения к GET/POST или SESSION могут быть только в контроллерах.
    Из базы должны выбираться только те записи, с которыми планируем работать. Нельзя выбирать всю таблицу целиком.
    Модель должна принимать отфильтрованные данные из контроллера. Нельзя передавать ей GET или POST целиком.
    В шаблонах не должно быть inline стилей и скриптов.
    Защита от SQL-инъекций - один из самых "дорогих" пунктов. Обязательно ипользовать параметризированные запросы или ручное экранирование данных пользовательского ввода. Обратите внимание на сортировку.
    Любой повторяющийся код - зло. (См. "Предотвращение дублирования кода" раздел 7.1 Макконнелла).
    В приложении должна быть одна точка входа. Желательно также разделить код приложения и публичные файлы. Это значит, что нельзя сделать запрос вида domain.name/controllers/MyController.php т.к. исходники лежат выше чем HTTP ROOT.
    При написании роутера учтите, что приложение может находиться не в корне сайта (например точкой входа может являться путь some-domain.com/coding-challenges/some-developer-name/index.php).
    Ну, и обязательно используйте автозагрузку вместо ручного подключения файлов через require. Автозагрузку можно написать самому, или взять готовый метод.

Протокол тестирования

    Перейти на стартовую страницу приложения. Должен отобразиться список задач. В списке присутствуют поля: имя пользователя, email, текст задачи, статус. Не должно быть опечаток. Зазоры должны быть ровные. Ничего не ползет. Должна быть возможность создания новой задачи. Должна быть кнопка для авторизации.
    Не заполнять поля для новой задачи. Сохранить задачу. Должны вывестись ошибки валидации. Ввести в поле email “test”. Должна вывестись ошибка, что email не валиден.
    Создать задачку с корректными данными (имя “test”, email “test@test.com”, текст “test job”). Задача должна отобразиться в списке задач. Данные должны быть ровно те, что были введены в поле формы. После создания задачи должно вывестись оповещение об успехе добавления (обратная связь).
    Для проверки XSS уязвимости нужно создать задачу с тегами в описании задачи (добавить в поле описания задачи текст "<script>alert('test')</script>", заполнить остальные поля). Задача должна отобразиться в списке задач, при этом не должен всплыть alert c текстом ‘test’.
    Создать еще 2 задачи. Должна появиться новая страница в пагинации.
    Отсортировать список по полю “имя пользователя” по возрастанию. Список должен пересортироваться. Перейти на последнюю страницу в пагинации. Сортировка не должна сбиться, задачи с последней страницы должны быть отображены. Далее отсортировать по тому же полю, но по убыванию. Перейти на первую страницу. Имя пользователя, которое было последним в списке, должно стать первым. Проделать этот тест для полей “email” и “статус”.
    Перейти на страницу авторизации пользователя. Попробовать залогиниться с пустыми полями. Должна вывестись ошибка, что поля обязательны для заполнения или, что введенные данные не верные. Ввести в поле для имени пользователя “admin1”, в поле для пароля “321”. Должна вывестись ошибка о неправильных реквизитах доступа. Админский доступ не должен быть предоставлен. Ввести данные “admin” в поле для имени и “123” в поле для пароля. Авторизация должна пройти успешно. Должна отобразиться кнопка для выхода из профиля админа.
    Для созданной задачи проставить отметку “выполнено”. Перезагрузить страницу. Отредактировать текст задачи. Сохранить и перезагрузить страницу. Текст задачи должен быть тот, который ввели при редактировании. В общем списке задача должна отображаться уже с двумя отметками: "выполнено" и “отредактировано администратором”. Отметка “отредактировано администратором” должна появляться только в случае изменения текста в теле задачи.
    В общем списке задача должна отображаться со статусом задачи “выполнено”.
    Открыть параллельно приложение в новой вкладке. Разлогиниться в новой вкладке. В этой вкладке не должно быть возможности редактировать задачу. Вернуться в предыдущую вкладку. Отредактировать задачу и сохранить. Отредактированная задача не должна быть сохранена. Приложение должно запросить авторизацию.
