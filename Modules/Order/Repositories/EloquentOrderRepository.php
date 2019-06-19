<?php
namespace Modules\Order\Repositories;

use Modules\Order\Entities\Order;
use App\User;

class EloquentOrderRepository implements OrderRepository
{
  private $model;

  /**
   * EloquentOrderRepository constructor.
   * @param Order $model
   */
  public function __construct(Order $model)
  {
    $this->model = $model;
  }

  public function getAll() {
    return $this->model->all();
  }

  public function getById($id)
  {
    // TODO: Implement getById() method.
  }

  public function create()
  {
    $user = User::where('email', request('email'))->first();
    if($user) {
      $user->update([
        'name' => request('fio'),
        'company_name' => request('company_name'),
        'telephone' => request('telephone')
      ]);
    }
    else {
      $user = User::Create([
        'name' => request('fio'),
        'email' => request('email'),
        'company_name' => request('company_name'),
        'password' => bcrypt(str_random(10)),
        'telephone' => request('telephone')
      ]);
    }

    return $this->model->create([
      'number' => strtoupper(substr(uniqid(sha1(time())),0,5)),
      'user_id' => $user->id,
      'note' => request('note')
    ]);
  }

  public function update($id, array $attributes)
  {
    // TODO: Implement update() method.
  }

  public function delete($id)
  {
    // TODO: Implement delete() method.
  }
}