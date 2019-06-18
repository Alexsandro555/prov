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
            <filter-products :products="{{$products}}" :attributes="{{$attributes}}">
              <template slot-scope="{products, getImages, getUrl}">
                <div v-for="product in products" :key="product.id" class="special-product-wrapper">
                  <div class="special-product text-xs-center" align="center">
                    <div class="special-product__header text-xs-center">
                      <a :href="'/catalog/detail/'+product.url_key">@{{product.title.length>52?product.title.substr(0,50)+'...':product.title}}</a>
                    </div>
                    <div class="special-product__img">
                      <v-layout fill-height text-xs-center>
                        <a :href="getUrl(product)" style="display: inline-block; text-align: center;  margin:0 auto;">
                          <template v-if="getImages(product).length > 0">
                            <img :src="'/storage/'+getImages(product)[0].config.files.medium.filename" style="margin: 0px auto;"/>
                          </template>
                          <template v-else>
                            <img src="/images/no-image-medium.png"/>
                          </template>
                        </a>
                      </v-layout>
                    </div>
                    <div class="special-product__desc text-xs-center">Наличие на складе</div>
                    <v-layout col wrap class="special-product__mcart">
                      <v-flex xs8 class="special-product__price text-xs-center">
                        <!--<span class="old-price">145 800</span> руб.<br>-->
                        <span class="current-price">@{{Math.floor(product.price)}}</span> <span class="rub">руб.</span>
                      </v-flex>
                      <v-flex xs4 class="special-product__cart">
                        <a :href="'/catalog/detail/'+product.url_key">
                          <img src="/images/product-cart.png"/>
                        </a>
                      </v-flex>
                    </v-layout>
                  </div>
                </div>
              </template>
            </filter-products>
          </v-flex>
        </v-flex>
      </v-layout>
    </div>
  </div>
@endsection