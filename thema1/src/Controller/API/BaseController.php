<?php

namespace Controller\API;

use Model\BaseModel;
interface BaseController {
    public function index();
    public function show();
    public function create();
    public function update();
    public function delete();
}