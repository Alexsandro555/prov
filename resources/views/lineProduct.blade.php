@extends('layouts.master')

@section('title', $model->meta_title?$model->meta_title:'Купить '.$model->title.' по доступным ценам')
@section('meta-description', $model->meta_description?$model->meta_description:'Купить '.$model->title.' '.str_limit(strip_tags($model->description), $limit = 160, $end="..."))
@section('meta-keywords', $model->meta_keywords?$model->meta_keywords:config('info.keywords'))

@section('breadcrumbs')
  <div class="abs-breadcrumbs">
    {{ Breadcrumbs::render() }}
  </div>
@endsection

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu/>
    </div>
  </div>
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="content" style="position: relative">
      <v-layout row wrap>
        <v-flex xs11 offset-xs1 md9 offset-md3 text-xs-left>
          <v-layout column wrap>
            <p class="content__header text-md-left">
              {{$model->title}}
            </p>
            <p class="content-discription">
              {!! $model->description !!}
            </p>
          </v-layout>
          <v-flex xs12 class="text-xs-left">
            <filter-products :products="{{$products}}" :attributes="{{$attributes}}">
              @include('product')
            </filter-products>
          </v-flex>
        </v-flex>
      </v-layout>
    </div>
  </div>
@endsection