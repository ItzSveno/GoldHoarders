<?php

namespace GoldHoarders\Controllers;

interface BaseController {
    public function index();
    public function show();
    public function create();
    public function update();
    public function delete();
}