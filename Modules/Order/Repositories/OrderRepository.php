<?php

namespace Modules\Order\Repositories;

interface OrderRepository
{
  public function getAll();

  public function getById($id);

  public function create();

  public function update($id, array $attributes);

  public function delete($id);
}

