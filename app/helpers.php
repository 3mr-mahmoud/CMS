<?php
if (! function_exists('controlPanelUrl')) {
    /**
     * returns the full qualified url with fixed control panel prefix
     *
     * @param  string  $target
     * @param  string  $prefix
     * @return string $url
     */
    function controlPanelUrl($target, $prefix = '/control-panel/')
    {
        $safeTarget = starts_with($target,'/') ? substr($target,1) : $target;
        $locale = app()->environment('testing')? 'ar' : request()->segment(1);
        if(app()->environment('testing')) return $locale.$prefix.$safeTarget;
        return app()->make('url')->to($locale.$prefix.$safeTarget);
    }
}
if (! function_exists('dataChoice')) {
    /**
     * decides whether to show old data or new data instead
     *
     * @param  string  $target
     * @param  string  $prefix
     * @return string $url
     */
    function dataChoice($name, $data)
    {
        if(old($name)) return old($name);
        return $data->$name;
    }
}
?>