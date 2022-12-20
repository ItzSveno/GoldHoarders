<?php declare(strict_types=1);

namespace Model;

interface BaseModel {
    public static function all() : array;
    public static function find(int $id) : BaseModel;
    public static function create(BaseModel $entity) : BaseModel;
    public static function update(BaseModel $entity) : BaseModel;
    public static function delete(int $id) : bool;
}