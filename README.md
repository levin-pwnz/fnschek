# fnschek

Как подключить в проект?

**В файл config/app.php**
В секцию с сервис провайдерами добавить в конец, после установки пакета

<code> \LevinPwnz\FnsCheck\FnsServiceProvider::class</code>

После добавления сервис провайдера необходимо выолнить:
`artisan vendor:publish`

После открыть `fnsconfig.php` и указать логин и пароль для доступа к ФНС
