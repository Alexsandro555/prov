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
      <v-flex class="content__info" xs12>
        @if($products->isNotEmpty())
          <v-flex xs12><h1>Результаты поиска:</h1></v-flex>
          @include('products',['products' => $products])
        @else
          <h1>По вашему запросу ничего не найдено</h1>
        @endif
      </v-flex>
    </div>
  </div>
@endsection
