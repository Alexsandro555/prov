<h1>Заказан обратный звонок!</h1><br>
<span>Заказчик: <strong>{{$callback->name}}</strong></span><br><br>
@if($callback->company_name)
  Название компании: <span><strong>{{$callback->company_name}}</strong></span><br>
@endif
Email: <span><strong>{{$callback->email}}</strong></span><br>
Телефон: <span><strong>{{$callback->telephone}}</strong></span><br>
Примечание: <p>
  {{$callback->comment}}
</p>
