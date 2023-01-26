<?php

namespace Controller\API;

interface BaseController {
    public function index();
    public function show();
    public function create();
    public function update();
    public function delete();
}