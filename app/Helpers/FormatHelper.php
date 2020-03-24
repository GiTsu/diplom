<?php

namespace App\Helpers;

use App\Models\Streams;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;


class FormatHelper
{
    const CAMS_WEB = 1;
    const CAMS_API = 2;

    const FORMAT_SECONDS = 1;
    const FORMAT_MINUTES = 60;
    const FORMAT_HOURS = 3600;
    const FORMAT_DAYS = 86400;





    /**
     * Сделать дату карбоном с обработкой исключений (null в случае неправильного формата)
     *
     * @param $date
     * @return Carbon|null
     */
    public static function makeCarbon($date): ?Carbon
    {
        if (!($date instanceof Carbon)) {
            try {
                return Carbon::parse($date);
            } catch (\Exception $e) {
                Log::error('Carbon не смог распарсить дату', ['raw' => $date, 'todo' => 'log trace debug_backtrace()']);
                return null;
            }
        }
        return $date;
    }

    /**
     * @param int $len
     * @param null $randomSeed
     * @return false|string
     */
    public static function makeHash($len = 5, $randomSeed = null)
    {
        // todo uniqueid?
        if (empty($randomSeed)) {
            $randomSeed = rand(1, 100);
        }
        return substr(md5(microtime() . $randomSeed), 0, $len);
    }


    /**
     * @param int $seconds
     * @param int $format
     * @param bool $roundFloor
     * @return false|float
     */
    public static function convertSecondsTo(int $seconds, $format = FormatHelper::FORMAT_DAYS, $roundFloor = true)
    {
        $result = $seconds / $format;
        return ($roundFloor) ? floor($result) : ceil($result);
    }

    /**
     * Генерация массива ключ-значение для селекта.
     * idField - поле для ключа, $titleField - имя поля значения или вызываемой функции при флаге $callableTitle = true
     *
     * @param Collection $collection
     * @param $idField
     * @param $titleField
     * @param bool $callableTitle
     * @return array
     */
    public static function getObjectsCollectionFormSelectData(
        Collection $collection,
        $idField,
        $titleField,
        $callableTitle = false
    ): array
    {
        // можно $devStrings = MonTypeDesc::where([['fid', 2]])->select("id", "name")->get()->pluck('name', 'id');
        // но не для callable
        $result = [];
        if ($collection->isNotEmpty()) {
            foreach ($collection as $item) {
                if (!$callableTitle) {
                    if (isset($item->{$idField}) && isset($item->{$titleField})) {
                        $result[$item->{$idField}] = $item->{$titleField};
                    }
                } else {
                    if (isset($item->{$idField}) && method_exists($item, $titleField)) {
                        $result[$item->{$idField}] = $item->{$titleField}();
                    } else {
                        $result[$item->{$idField}] = 'Wrong callable ' . $titleField;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public static function getYesNoSelect(): array
    {
        return ['0' => 'Нет', '1' => 'Да'];
    }

    /**
     * @param Carbon $time
     * @return int
     */
    public static function getAbsDiffInSeconds(Carbon $time): int
    {
        $resendAfterSeconds = $time->diffInSeconds(Carbon::now());
        if ($resendAfterSeconds < 0) {
            $resendAfterSeconds = 0;
        }
        return $resendAfterSeconds;
    }
}

?>
