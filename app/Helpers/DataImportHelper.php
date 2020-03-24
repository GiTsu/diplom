<?php

namespace App\Helpers;

use App\Models\City;
use App\Models\Location;
use App\Models\Rate;
use App\Models\User;
use App\Models\UserLocationRate;
use App\Models\UserProfileBbnkl;
use App\Services\CompatService;
use Carbon\Carbon;


class DataImportHelper
{
    public static $CSVdelimiter = ',';

    /**
     * Структура файла импорта с фильтрами и генерацией файла-образца по массиву.
     * Редактируя индексы - редактируй и код фильтров и импорта. По-умолчанию добавляем в конец новые поля без переработки кода.
     * Поле город пока используется только в локациях, нужно проверять локацию Город-Садик-Группа сцепленно ( @todo метод с одним запросом)?
     * Для новых проверок - в checkUserCSVData добавить в switch условие и его идентификатор через запятую в массив в поле filter
     * Сделать проверку разделителя
     */
    private static $rules = [
        0 => ['name' => 'Город', 'field' => '', 'filter' => 'notEmpty', 'comment' => 'Саратов'],
        1 => ['name' => 'Название организации', 'field' => '', 'filter' => 'locLev1Exists', 'comment' => ''],
        2 => ['name' => 'Название группы', 'field' => '', 'filter' => 'locLev2Exists', 'comment' => '', 'linked' => 1],
        3 => ['name' => 'Фамилия', 'field' => '', 'filter' => 'orFullname', 'comment' => '', 'linked' => 9],
        4 => ['name' => 'Имя', 'field' => '', 'filter' => 'orFullname', 'comment' => '', 'linked' => 9],
        5 => ['name' => 'Отчество', 'field' => '', 'filter' => '', 'comment' => ''],
        6 => ['name' => 'Телефон', 'field' => '', 'filter' => 'phoneUnique,notEmpty,len10', 'comment' => '9001112233'],
        7 => ['name' => 'Ребенок', 'field' => '', 'filter' => 'notEmpty', 'comment' => 'Фио'],
        8 => ['name' => 'ДР ребенка', 'field' => '', 'filter' => 'notEmpty,isDate', 'comment' => '07.10.2014 12:00:00'],
        9 => ['name' => 'Полное фио.род', 'field' => '', 'filter' => '', 'comment' => 'фио.родителя'],
    ];
    private static $cityCache = [];


    public static function getUserCSVImportRules()
    {
        return self::$rules;
    }


    public static function readCSVFile($path)
    {
        if (($fp = fopen($path, "rt")) !== false) {
            $fileData = [];
            while (($row = fgetcsv($fp, 1024, self::$CSVdelimiter)) !== false) {
                $fileData[] = $row;
            }
            return $fileData;

        } else {
            return false;
        }

    }

    public static function fixFuckUp($path)
    {
        // case #1
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $content = str_replace("\n\"\n", "\n", $content);
            $content = preg_replace_callback(
                "/\"\n(.*)\n\"/",
                function ($matches) {
                    return str_replace("\n", "", $matches[0]);
                },
                $content
            );

            $content = str_replace("\"\n", "\"", $content);
            // case #1
            file_put_contents($path, $content);
        }
    }

    /* public static function locationExists($where=[])
     {
         $location = Location::where($where)->first();
         if (!empty($location) && $location->count()) {
             return $location->id;
         }
         else {
             return FALSE;
         }
     }*/

    public static function checkUserCSVData($dataArray)
    {
        $result = ['status' => true, 'errors' => [], 'errnum' => []];
        if (!empty($dataArray)) {
            // slice the header row, possibly checking its text or version checkUserCSVDataHeader
            $header = array_shift($dataArray);
            // check on delimiter
            if (count($header) <= 1) {
                $result['status'] = false;
                $result['errors'][] = 'Возможно, неверный разделитель при сохранении CSV, разделитель - запятая (,)';
                return $result;
            }
            $currentRowIndex = 2;

            //die(print_r($dataArray,true));
            // num of fields decribed
            $rulesCount = count(self::$rules);

            foreach ($dataArray as $row) {
                // checking cycle
                $rowCount = count($row);
                if ($rulesCount != $rowCount) {
                    // return columns error
                    $result['status'] = false;
                    $result['errors'][] = 'Несовпадение количества колонок в строке №' . $currentRowIndex . print_r($row,
                            true) . ', скачать образец, разделитель - запятая (,)';
                } else {

                    for ($i = 0; $i < $rulesCount; $i++) { // check every field

                        $rules = explode(',', self::$rules[$i]['filter']);

                        foreach ($rules as $rule) {
                            switch (trim($rule)) {
                                case 'notEmpty': // phone number unique?

                                    if (empty($row[$i])) {
                                        $result['status'] = false;
                                        $result['errors'][] = 'Пустая ячейка в строке №' . $currentRowIndex . ', поле: ' . self::$rules[$i]['name'];
                                        $result['errnum'][] = $currentRowIndex;
                                    }
                                    break;
                                case 'phoneUnique': // phone number unique?
                                    $userID = self::phoneExistsInUsers($row[$i]);
                                    if (!empty($userID)) {
                                        $result['status'] = false;
                                        $result['errors'][] = 'Номер телефона не уникален в строке №' . $currentRowIndex . ', userid:' . $userID . ', данные: ' . $row[$i];
                                        $result['errnum'][] = $currentRowIndex;
                                    }
                                    break;
                                case 'len10': // телефон из 10 цифр
                                    $phoneOk = self::phone10Len($row[$i]);
                                    if (!$phoneOk) {
                                        $result['status'] = false;
                                        $result['errors'][] = 'Номер неправильной длины в строке №' . $currentRowIndex . ', данные: ' . $row[$i];
                                        $result['errnum'][] = $currentRowIndex;
                                    }
                                    break;
                                case 'locLev1Exists':
                                    $location = self::findLocation($row[0], $row[$i]);
                                    if (empty($location)) {
                                        $result['status'] = false;
                                        $result['errors'][] = 'Корневая не существует в строке №' . $currentRowIndex . ', данные: ' . $row[$i];
                                        $result['errnum'][] = $currentRowIndex;
                                    }
                                    break;
                                case 'locLev2Exists':
                                    $linkedIndex = self::$rules[$i]['linked'];
                                    $location = self::findSubLocation($row[0], $row[$linkedIndex], $row[$i]);

                                    if (empty($location)) {
                                        $result['status'] = false;
                                        $result['errors'][] = 'Дочерняя локация не существует в строке №' . $currentRowIndex . ', данные: ' . $row[$i];
                                        $result['errnum'][] = $currentRowIndex;
                                    }
                                    break;
                                case 'isDate': // 07.10.2014 12:00:00 || 07.10.2014 || 07.10.14
                                    $str = self::cutDate($row[$i]);
                                    $match = preg_match("/^[0-3][0-9]\.[0-1][0-9]\.19|20[0-9]{2}$/", $str);

                                    if (!$match) {
                                        $result['status'] = false;
                                        $result['errors'][] = 'Неправильная дата в строке №' . $currentRowIndex . ', данные: ' . $row[$i];
                                        $result['errnum'][] = $currentRowIndex;
                                    } else {
                                        try {
                                            Carbon::parse(self::cutDate($str));
                                        } catch (\Exception $e) {
                                            $result['status'] = false;
                                            $result['errors'][] = 'Косяк формата даты в строке №' . $currentRowIndex . ', данные: ' . $row[$i];
                                            $result['errnum'][] = $currentRowIndex;
                                        }
                                    }

                                    break;
                                case 'orFullname':
                                    $linkedIndex = self::$rules[$i]['linked'];
                                    if (empty($row[$i]) && empty($row[$linkedIndex])) {
                                        $result['status'] = false;
                                        $result['errors'][] = 'Не заполнено ФИО в строке №' . $currentRowIndex . ', поле: ' . self::$rules[$i]['name'];
                                        $result['errnum'][] = $currentRowIndex;
                                    }
                                    break;
                            }
                        }

                    }
                }
                $currentRowIndex++;
            }
        } else {
            $result['status'] = false;
            $result['errors'][] = 'Пустой файл с данными';
        }
        return $result;
    }

    public static function phoneExistsInUsers($phoneNumber)
    {
        $phoneNumber = self::sanitizePhone($phoneNumber);
        $users = User::where('number', '=', $phoneNumber);
        $sql = $users->toSql();
        $users = $users->first();

        if (!empty($users) && $users->count()) {
            return $users->id;
        } else {
            return false;
        }
    }

    /**
     * @param $raw
     */
    public static function sanitizePhone($raw)
    {
        $raw = (string)$raw;
        $raw = preg_replace('/[^0-9]/', '', $raw);
        $len = strlen($raw);
        if ($len > 10) {
            $raw = substr($raw, -10);
        }
        return (int)$raw;
    }

    public static function phone10Len($raw)
    {
        $phoneNumber = self::sanitizePhone($raw);
        return (strlen($phoneNumber) == 10) ? 1 : 0;
    }

    public static function findLocation($city, $location)
    {
        // @todo нормальный запрос c учетом города
        $cityID = self::findCityID($city);
        $location = trim($location);
        if (!empty($cityID)) {
            return Location::where([
                ['city_id', '=', $cityID],
                ['pid', '=', 0],
                ['name', '=', trim($location)]
            ])->first();
        } else {
            return false;
        }

    }

    public static function findCityID($cityName)
    {
        $cityName = trim($cityName);
        if (!empty(self::$cityCache[$cityName])) { // ['saratov' => id]
            return self::$cityCache[$cityName];
        } else {
            $city = City::where([['name', '=', $cityName]])->first();
            if (!empty($city)) { // cache It!
                self::$cityCache[$cityName] = $city->id;
                return $city->id;
            } else {
                return false;
            }
        }

    }

    public static function findSubLocation($city, $location, $subLocation)
    {
        // @todo нормальный запрос с учетом города и родителя
        $subLocation = trim($subLocation);
        $obj1 = self::findLocation($city, $location);
        if (!empty($obj1)) {
            return $obj2 = Location::where([['pid', '=', $obj1->id], ['name', '=', $subLocation]])->first();
        } else {
            return false;
        }
    }

    public static function cutDate($str)
    {
        $str = trim($str);
        $str = str_replace(',', '.', $str);
        // обрежем время, 10 символов, 07.10.14 || 07.10.2014 || 00:00:00
        $str = substr($str, 0, 10);
        if (!preg_match("/^[0-3][0-9]\.[0-1][0-9]\.19|20[0-9]{2}$/", $str)) {
            // не 2014, добавить 20+14
            $str = substr($str, 0, 8);
            $str = substr($str, 0, 6) . 20 . substr($str, 6);
        }
        return $str;
    }

    /**
     * Подготовка пароля для базы
     *
     * @param string $password
     * @return string
     */
    public static function sanitizePassword($password)
    {
        $password = trim($password);
        return $password;
    }

    /**
     * @param $raw
     */
    public static function sanitizeUsername($raw)
    {
        $raw = trim($raw);
        return $raw;
    }

    public static function importUserCSVData($dataArray, $rateId, $except = [])
    {
        $result = ['status' => true, 'count' => 0, 'persons' => []];
        if (!empty($dataArray)) {
            $currentRowIndex = 2;

            foreach ($dataArray as $row) {
                if (!in_array($currentRowIndex, $except)) {
                    $username = self::getCorrectName($row);
                    $newUser = User::create([
                        'name' => $username,
                        'email' => '',
                        'number' => self::sanitizePhone($row[6]),
                        'password' => bcrypt(str_random(6)),
                        'status' => User::STATUS_ON_MODERATION,
                        'imported' => 1,
                    ]);
                    // create a profile
                    $profile = UserProfileBbnkl::where('user_id', $newUser->id)->first();
                    if (empty($profile)) {
                        $profile = new UserProfileBbnkl();
                        $profile->user_id = $newUser->id;
                        $profile->phone = $newUser->number;
                        $profile->fio_rod = $newUser->name;
                        $profile->fio_childe = $row[7];
                        $profile->birthday = self::sanitizeBirthday($row[8]);
                        $profile->save();
                    }
                    // роль в доступе
                    $newUser->assignRole('client');


                    //location
                    $location = self::findSubLocation($row[0], $row[1], $row[2]);


                    if (!empty($location) && $location->count()) {
                        // смотрим тариф для текущей локации
                        $assignRateId = $rateId;
                        // если выбран авто-тариф - определять для каждого
                        if (empty($rateId)) {
                            $assignRateId = Rate::getDefaultRate($location->id);
                        }
                        UserLocationRate::addToUser([
                            'location_id' => $location->id,
                            'type' => 1,
                            'rate_id' => $assignRateId
                        ],
                            $newUser);
                        // тариф
                        $newUser->rates()->attach($assignRateId);

                        // создали пользователя, конвертируем в v3
                        $newUser->refresh();
                        $compatService = new CompatService();
                        $compatService->convertBbnklToV3($newUser);
                    }

                    $result['count']++;
                    $result['persons'][] = [
                        'name' => $newUser->name,
                        'id' => $newUser->id,
                        'profileID' => $profile->id
                    ];

                }
                $currentRowIndex++;
            }
        }


        return $result;


    }

    public static function getCorrectName($row)
    {
        // склеиваем имя из ФИО или берем поле полное имя
        $name = (empty($row[3]) && empty($row[4])) ? $row[9] : $row[3] . ' ' . $row[4] . ' ' . $row[5];

        return self::sanitizeRealName($name);
    }

    public static function sanitizeRealName($rawName)
    {
        $rawName = str_replace("\n", " ", $rawName);
        // удалить все кроме букв, тире и пробелов
        $rawName = preg_replace('/[^а-яА-Яa-zA-Z\-\ \(\)]/ui', '', $rawName);
        // удалить повторные пробелы
        $rawName = preg_replace('/[\s]{2,}/u', ' ', $rawName);

        return trim($rawName);
    }

    /**
     * @param $raw
     * @return false|string
     */
    public static function sanitizeBirthday($raw)
    {
        return Carbon::parse(self::cutDate($raw))->format('d/m/Y');
        //return date("d/m/Y", strtotime($raw));
        //return date('Y-m-d H:i:s',strtotime($raw));
    }

    /**
     * Конвертируем 14/12/2015 в 2015-12-14
     * Боремся с мутатором даты рождения у профиля bbnkl, который коверкает timestamp под формат плагина
     *
     * @param $raw
     * @param bool $defaultNow
     * @return string
     */
    public static function convertSlashDate2TS($raw, $defaultNow = false)
    {
        // $raw = 14/12/2015
        $date = '';
        $arr = explode('/', $raw);
        if (count($arr) === 3) {
            $date = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
        }
        if ($defaultNow && empty($date)) {
            $date = Carbon::now()->format('Y-m-d H:i:s');
        }
        return $date;
    }

    public static function isEmptyMail($email)
    {
        return (empty($email) || preg_match("/empty-mail-([\d]*)\@bbnkl\.ru/", $email));
    }

    public static function returnCSVResponce($filename, array $tableRows, array $tableHeaders = [], array $headers = [])
    {
        // для
        $headers = array_merge([
            'Content-Type' => 'text/csv',
            'Content-Encoding' => 'UTF-8',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Description' => 'File Transfer',
            "Cache-Control'=>'private",
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ], $headers);

        return response()->streamDownload(function () use ($tableHeaders, $tableRows) {
            if (!empty($tableHeaders)) {
                echo(implode(DataImportHelper::$CSVdelimiter, $tableHeaders));
            }

            if (!empty($tableRows)) {
                foreach ($tableRows as $key => $row) {
                    echo(implode(DataImportHelper::$CSVdelimiter, $row));
                }
            }
        }, $filename, $headers);

    }

    public static function formatUserPhoneNumber($number)
    {
        return '+7(' . mb_substr($number, 0, 3) . ')-' . mb_substr($number, 3, 3) . '-' . mb_substr($number, 6,
                2) . '-' . mb_substr($number, 8, 2) . '';
    }

}

?>
