<?php

namespace App\Exceptions;

use Exception;
class ScoreException extends Exception
{
    public $from;
    public $to;
    public $score;
    public function __construct($from,$to,$score)
    {
        $this->from = $from;
        $this->to = $to;
        $this->score = $score;
    }

    public function render() {
        return response()->json(
            trans("rating.scoreException", [
                "from" => $this->from,
                "to" => $this->to,
                "score"=>$this->score
            ])
        );
    }
}
