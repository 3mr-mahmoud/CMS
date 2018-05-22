<?php
namespace App\Settings;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Jsonable;

abstract class JsonModel implements Jsonable{
    protected $disk = 'local';
    protected $modelName;
    protected $data;
    protected $newData;
    public function __construct()
    {
        $this->modelName = (new \ReflectionClass($this))->getShortName().'.json';
        if(!$this->exists()) $this->add();
        $this->fresh();
    }
    protected function storage() {
        return Storage::disk($this->disk);
    }
    public function exists($key = null) {
        if($key) return array_key_exists($key,$this->data);
        return $this->storage()->exists($this->modelName);
    }
    public function add() {
        $this->storage()->put($this->modelName,json_encode(['exists'=>'true']));
    }
    public function get()
    {
        $this->data = $this->storage()->get($this->modelName);
        return $this;
    }
    public function put($key, $value = '') {
        if($this->exists($key)) return $this->edit($key, $value);
        $this->newData = [$key => $value];
        return $this->save();
    }

    protected function edit($key, $value)
    {
        $this->data[$key] = $value;
        return $this->save();
    }

    public function save()
    {
        if($this->newData) $this->data += $this->newData;
        $this->storage()->put($this->modelName,json_encode($this->data));
        return $this->get()->toJson();
    }

    protected function fresh()
    {
       $this->data = $this->get()->toArray();
       return $this;
    }
    public function toJson($options = 0){
        return json_encode($this->toArray(),$options);
    }
    public function toArray()
    {
        return json_decode($this->data, true);
    }

    public function __get($name)
    {
        if($this->exists($name)) return $this->data[$name];
        return;
    }
}