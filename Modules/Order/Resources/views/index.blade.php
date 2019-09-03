@extends('layouts.master')

@section('title', 'Закзаать '.config('info.site_name'))
@section('meta-description', 'Заказать '.config('info.site_name'))
@section('meta-keywords', 'Заказать, '.config('info.keywords'))

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
            <h1>Оформление заказа</h1>
          </v-card-title>
          <v-card-text>
            <v-layout justify-start>
              <order-form/>
            </v-layout>
          </v-card-text>
        </v-card>
      </v-flex>
    </div>
  </div>
@endsection