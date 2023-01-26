<?php

namespace Model;

interface BaseModel {
    public static function all() : array;
    public static function find(int $id) : BaseModel;
    public static function create(BaseModel $entity) : BaseModel;
    public function update() : BaseModel;
    public static function delete(int $id) : void;
}