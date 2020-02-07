@extends('layouts.master')

@section('title', $model->meta_title?$model->meta_title:'Купить '.$model->title.' по доступным ценам')
@section('meta-description', $model->meta_description?$model->meta_description:'Купить '.$model->title.' '.str_limit(strip_tags($model->description), $limit = 160, $end="..."))
@section('meta-keywords', $model->meta_keywords?$model->meta_keywords:config('info.keywords'))

@section('breadcrumbs')
  <!--<div class="abs-breadcrumbs">
    {{ Breadcrumbs::render() }}
  </div>-->
@endsection

@section('menu')
  <!--<div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu/>
    </div>
  </div>-->
@endsection

@section('content')
  <div class="content-wrapper">
    <v-container class="content hidden-md-and-down">
      <v-row class="no-gutters">
        <v-col cols="12">
          <h1 class="header-title">{{$model->title}}</h1>
          <v-card>
            <v-card-text style="min-height: 700px;">
              <filter-products :model-id="{{$model->id}}" :model-column-name="'type_product_id'"/>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <div class="hidden-lg-and-up">
      <v-container no-gutter class="ma-0 pa-3">
        <v-row>
          <v-col cols="12">
          </v-col>
        </v-row>
      </v-container>
    </div>
  </div>
@endsection