<?php
namespace App\Utils;

use App\Events\ModelRated;
use App\Exceptions\ScoreException;
use Exception;
use Illuminate\Database\Eloquent\Model;
Trait CantRate {

    public function ratings($model = null){
        $modelClass = $model ? $model : $this->getMorphClass();
        $morphToMany = $this->morphToMany(
            $modelClass,
            'qualifier',
            'rating',
            'qualifier_id',
            'rateable_id'
        );
        $morphToMany->as('rating')
                    ->withTimestamps()
                    ->withPivot('score','rateable_type')
                    ->wherePivot('rateable_type',$modelClass)
                    ->wherePivot('qualifier_type',$this->getMorphClass())
        ;

        return $morphToMany;
    }

    public function rate(Model $model, float $score) {

        if ($this->hasRated($model)) return false;

        $from = config('rating.from');
        $to = config('rating.to');
        if($score < $from || $score > $to){ 
            throw  new ScoreException($from,$to,$score);
        }
        $this->ratings($model)->attach($model->getKey(), [
            "score" => $score,
            "rateable_type" => get_class($model)
        ]);
        event(new ModelRated($this,$model,$score));
        return true;

    }

    public function unrate(Model $model): bool
    {
        if (! $this->hasRated($model)) {
            return false;
        }

        $this->ratings($model->getMorphClass())->detach($model->getKey());

        return true;
    }

    public function hasRated(Model $model): bool
    {
        return ! is_null($this->ratings($model->getMorphClass())->find($model->getKey()));
    }
}