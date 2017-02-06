<?php

namespace App\Models;

use App\Utils\Jalali\jDate;
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = array('starts_at_jalali', 'ends_at_jalali');

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

    /**
     * @return DateTime
     */
    public function getStartsAtJalaliAttribute(){
        return jDate::forge($this->starts_at)->format("Y/m/d H:i");
    }

    /**
     * @return DateTime
     */
    public function getEndsAtJalaliAttribute(){
        return jDate::forge($this->ends_at)->format("Y/m/d H:i");
    }
}
