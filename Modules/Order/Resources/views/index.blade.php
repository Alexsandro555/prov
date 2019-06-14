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
      <v-card class="detail-info">
        <v-card-title>
          <h1>Оформление заказа</h1>
        </v-card-title>
        <v-card-text>
          <v-layout justify-start>
            Тут содержимое
          </v-layout>
        </v-card-text>
      </v-card>
    </div>
  </div>
@endsection