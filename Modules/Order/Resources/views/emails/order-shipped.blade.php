<h1>Оформлен заказ!</h1><br>
<span>№ - <strong>{{$number}}</strong></span><br><br>
Email: <span><strong>{{$email}}</strong></span><br>
Телефон: <span><strong>{{$telephone}}</strong></span><br>
Примечание: <p>
  {{$note}}
</p><br><br>
<table>
  <thead>
  <th>#</th>
  <th>Название</th>
  <th>Цена</th>
  <th>Кол-во</th>
  </thead>
  <tbody>
  @foreach($products as $product)
    <tr>
      <td>{{$product->id}}</td>
      <td>{{$product->title}}</td>
      <td>{{$product->pivot->price}}</td>
      <td>{{$product->pivot->qty}}</td>
    </tr>
  @endforeach
  </tbody>
</table>
