<?php

namespace App\Models;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property integer id
 * @property DateTime starts_at
 * @property DateTime ends_at
 * @property DateTime created_at
 * @property DateTime updated_at
 *
 * Class Submit
 * @package App\Models
 */
class Timer extends BaseModel
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeAllowed($query){
        $now = date("Y-m-d H:i:s");
        return $query->whereDate('starts_at', '>=', $now)->whereDate('ends_at', '<=', $now);
    }

    /**
     * @return bool
     */
    public static function hasActiveContest(){
        if(Timer::allowed()->get()->isEmpty())
            return false;
        return true;
    }
}
