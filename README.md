# fnschek

Как подключить в проект?

**В файл config/app.php**
В секцию с сервис провайдерами добавить в конец, после установки пакета

<code> \LevinPwnz\FnsCheck\FnsServiceProvider::class</code>

После добавления сервис провайдера необходимо выолнить:
`artisan vendor:publish`

После открыть `fnsconfig.php` и указать логин и пароль для доступа к ФНС

Как использовать?

```
use LevinPwnz\FnsCheck\Fns;

class HomeController
{
    public function index(Fns $fns)
    {
        //Retrive all check items by check photo
        $data = $fns->getAllCheItems($checkFile);
        
        //Retrive info about a check
        $checkInformation = $fns->getInfoByCheck($checkFile);

        //Work with check items
        foreach ($data as $item) {
            print ($item->sum / 100);
        }
    }
}
```
