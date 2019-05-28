@extends('layouts.master')

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu :prop-toggle="true"></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="content">
    <div class="wrapper content__product-margin">
      <div class="breadcrumbs">
        <div class="wrapper">
          <v-flex xs12 text-xs-left>
            {{ Breadcrumbs::render() }}
          </v-flex>
        </div>
      </div>
      <v-flex xs12 text-xs-left class="top-20 bottom-20">
        <p class="headsite">
          <span>{{$model->title}}</span><br>
        </p>
        <v-layout row wrap>
          <filter-products :products="{{$products}}" :attributes="{{$attributes}}"/>
        </v-layout>
      </v-flex>
    </div>
  </div>
@endsection