<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function getAll($title);
    public function create(
        $request,
        $validated
    );
    public function show($id);
    public function edit($request, $id);
    public function update($id, $request, $validated);
    public function delete($id);
    // public function restore($id);
}
