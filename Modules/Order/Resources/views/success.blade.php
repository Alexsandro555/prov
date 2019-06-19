@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="content-wrapper text-xs-center">
    <div class="content">
      <v-flex xs12 md8 offset-md3>
        <v-card dark class="detail-info">
          <v-card-title>
            <h1 >Вы успешно оформили заказ</h1>
          </v-card-title>
          <v-card-text>
            <v-layout text-xs-left justify-start column wrap>
              <span class="number_order">№ Вашего заказа - <strong>{{$number}}</strong></span><br><br>
              <hr>
              <br><br>
              <p class="order-advanced-info">
                <strong>Важная информация!</strong><br><br>
                В течение нескольких часов наш оператор свяжется с Вами для личного подтверждения заказа.<br>
                В случае уточнения параметров заказа Вы можете использовать № присовенный заказу - {{$number}}<br>
                <strong>Благодарим Вас, за то что выбрали нашу компанию!</strong><br>
              </p>
            </v-layout>
          </v-card-text>
        </v-card>
      </v-flex>
    </div>
  </div>
@endsection