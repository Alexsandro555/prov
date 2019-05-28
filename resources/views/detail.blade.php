@extends('layouts.master')

@section('breadcrumbs')
  <div class="abs-breadcrumbs">
    {{ Breadcrumbs::render() }}
  </div>
@endsection

@section('menu')
  <div class="menu-wrapper wrapper">
    <div class="abs-position">
      <left-menu></left-menu>
    </div>
  </div>
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="content">
      <v-flex xs11 offset-xs1 md9 offset-md3>
        <v-card class="detail-info" style="min-height: 700px; font-size: 1.2em;">
          <v-layout row wrap>
            <v-flex pa-2 xs5>
              <detail-image :stock="{{$product->special?$product->special:'false'}}" :url="'/files/product-image/{{$product->id}}'" :id="{{$product->id}}"/>
              <!--<detail-image :url="'/files/product-image/{{$product->id}}'"/>-->
            </v-flex>
            <v-flex class="detail__title text-xs-left" px-5 xs7 md7>
              <h1>{{$product->title}}</h1>
              <p>
                                    <span class="detail__price">
                                        <span class="detail__price--big">{{$product->price}}</span> ₽{{$product->price_amount?'/'.$product->price_amount:""}}
                                    </span><br>
                @if($product->vendor)
                  <v-chip color="yellow">арт. {{$product->vendor}}</v-chip>
                @endif
              </p>
              <div class="figure-button__wrapper">
                <a class="figure-button" @click="addCart({{$product->id}})" href="#">
                  Заказать
                  <img src="{{asset('images/btn-sale-image.png')}}" align="center"/>
                </a>
              </div>
            </v-flex>
            <v-flex class="detail__tabs" pa-2 xs10>
              <br>
              <v-tabs class="detail-characteristics" color="green darken-4" dark slider-color="yellow">
                <v-tab key="description">Опсание</v-tab>
                <v-tab key="characteristics">Характеристики</v-tab>
                <v-tab-item key="description">
                  <br>
                  <span class="text-xs-left" style="color: white">
                                   {!! $product->description !!}
                                </span>
                </v-tab-item>
                <v-tab-item key="characteristics">
                  <br>
                  <div class="detail-characteristics__left-table">
                    <table class="detail-characteristics__table">
                      <tbody>
                      <?php $counter=1; ?>
                      @foreach($product->attributes as $attribute)
                        @if($attribute->pivot->value)
                          <tr>
                            <td>{{$attribute->title}}</td>
                            <td  class="tbl-left">{{$attribute->pivot->value}}</td>
                          </tr>
                          <?php
                          $counter++;
                          if($counter>9)
                          {
                            echo "</tbody></table></div><div class='detail-characteristics__right-table'><table class='detail-characteristics__table'><tbody>";
                            $counter=1;
                          }
                          ?>
                        @endif
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                </v-tab-item>
              </v-tabs>
            </v-flex>
          </v-layout>
        </v-card>
      </v-flex>
    </div>
  </div>
@endsection