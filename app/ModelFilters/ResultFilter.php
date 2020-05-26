<?php

namespace App\ModelFilters;

use App\Helpers\FormatHelper;
use EloquentFilter\ModelFilter;

class ResultFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];
    //
    protected $blacklist = [];

    public function test($id)
    {
        return $this->where('test_id', $id);
    }

    public function group($id)
    {
        return $this->related('user', 'group_id', '=', $id);
    }

    public function day($day) //2020-05-06
    {
        $date = FormatHelper::makeCarbon($day);
        // TODO: учет даты начала в этот день
        return $this->where(function ($q) use ($date) {
            return $q->where('start_at', '>=', $date->startOfDay()->format('Y-m-d H:i:s'))
                ->where('start_at', '<=', $date->endOfDay()->format('Y-m-d H:i:s'));
        });
    }

    public function mark($id)
    {
        return $this->where('mark', $id);
    }

}
