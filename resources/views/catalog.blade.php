@extends('layouts.master')

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
            <v-container grid-list-md>
              <v-layout align-center justify-left row wrap>
                @if($model->lineProducts)
                  @foreach($model->lineProducts as $lineProduct)
                    <div class="special-product-wrapper">
                      <div class="special-product text-xs-center" align="center">
                        <div class="special-product__header text-xs-center">
                          <a href="/catalog/{{$model->product_category->url_key}}/{{$model->url_key}}/{{$lineProduct->url_key}}">{{str_limit($lineProduct->title, $limit = 27, $end="...")}}</a>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
                @if($model->typeProducts)
                  @foreach($model->typeProducts as $typeProduct)
                    <div class="special-product-wrapper">
                      <div class="special-product text-xs-center" align="center">
                        <div class="special-product__header text-xs-center">
                          <a href="/catalog/{{$model->url_key}}/{{$typeProduct->url_key}}">{{str_limit($typeProduct->title, $limit = 27, $end="...")}}</a>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
              </v-layout>
            </v-container>
          </v-flex>
        </v-flex>
      </v-layout>
    </div>
  </div>
  <div class="best-sale">
    <div class="wrapper">
    </div>
  </div>
@endsection