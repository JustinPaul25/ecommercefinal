<?php

if (! function_exists('createLog')) {
    function createLog($model, $inputs, $log)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($model)
            ->withProperties($inputs)
            ->log($log);
    }
}