@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu :prop-toggle="false"></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="content">
    <div class="wrapper content__product-margin">
      <v-flex xs12 text-xs-left class="top-20 bottom-20">
        <v-layout row wrap>
          @if($products->isNotEmpty())
            <v-flex xs12><h1>Результаты поиска:</h1></v-flex>
            @include('products',['products' => $products])
          @else
            <h1>По вашему запросу ничего не найдено</h1>
          @endif
        </v-layout>
      </v-flex>
    </div>
  </div>
@endsection