<?php declare(strict_types=1);

namespace Controller\API;

use Model\BaseModel;
interface BaseController {
    public function index();
    public function show(?int $id);
    public function create(?BaseModel $entity);
    public function update(?BaseModel $entity);
    public function delete(?int $id);
}