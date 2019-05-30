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
        <v-layout row wrap>
          <v-flex offset-xs3 xs6 class="hidden-md-and-down">
            <p class="content__header text-md-left">Наши акции и <span class="content__subheader">спецпредложения</span></p>
            <div class="banner"></div>
          </v-flex>
          <v-flex xs3 class="text-md-right hidden-md-and-down">
            <a class="content__buttom" href="#">Все акции <v-icon color="yellow darken-2" medium>keyboard_arrow_right</v-icon></a>
          </v-flex>
          <v-flex class="text-md-right hidden-md-and-down" offset-md3 xs9><img class="content__banner" src="{{asset('images/banner.png')}}"/></v-flex>
          <v-flex  offset-md3 xs8 md6>
            <p class="content__header text-sm-left">Рекомендуемые <span class="content__subheader hidden-sm-and-down">товары</span></p>
            <div class="banner"></div>
          </v-flex>
          <v-flex xs3 class="text-md-right hidden-xs-only">
            <a class="content__buttom" href="#">В каталог <v-icon color="yellow darken-2" medium>keyboard_arrow_right</v-icon></a>
          </v-flex>
          <v-flex class="text-md-center" offset-md3 offset-xs1 lg9 md8 sm9 xs10>
            <leader-slider :perpage=3 url="/products/special" :per-custom="[[200, 1], [480, 1], [720, 2], [960, 2], [1280, 3]]"></leader-slider>
          </v-flex>
        </v-layout>
      </v-flex>
    </div>
  </div>
  <div class="tree">
    <div class="about-wrapper about--green">
      <div class="about">
        <v-content>
          <div class="about__content">
            <v-flex xs12>
              <v-layout row wrap>
                <v-flex xs10 sm10 md3 class="news hidden-sm-and-down">
                  <p class="about__header text-xs-left">Новости</p>
                  @foreach($news as $oneNews)
                    <div class="text-xs-left news__conent ">
                      <span class="news__date"><span class="news__date-d">{{$oneNews->updated_at->format('d.')}}</span>{{$oneNews->updated_at->format('m.Y')}}</span><br>
                      <span class="news__header"><a href="/news/{{$oneNews->url_key}}">{{$oneNews->title}}</a></span><br>
                      <v-flex xs4 sm12>
                        {{str_limit(strip_tags($oneNews->content), $limit = 37, $end="...")}}
                      </v-flex>
                    </div>
                  @endforeach
                  <div class="text-xs-left">
                    <a class="content__buttom news__button" href="/news/list">Все новости</a>
                  </div>

                </v-flex>
                <v-flex class="text-xs-left about__main-info" xs10 sm10 md6>
                  <p class="about__header text-md-left">О компании <span class="content__subheader hidden-sm-and-down">и оборудовании</span></p>
                  <v-flex class="about__left" xs3 sm6 md12>
                    Группа Компаний - это универсальный поставщик оборудования и комплектующих для
                    птицеводства. Это оптимальное решение для птицефабрик, которые имеют оборудование различных
                    производителей и марок. В настоящее время мы поставляем запасные части, расходные материалы и
                    оборудование для содержания птицы ведущих мировых компаний.
                  </v-flex>
                  <v-flex class="about__left about__cit" xs3 sm6 md12>
                    Это всегда оригинальная продукция, стабильные сроки поставки Товара и гарантия качества. Склады запасных
                    частей и расходных материалов расположены в городе Смоленске (Российская Федерация) и в городе Минске (Республика Беларусь)
                  </v-flex>
                  <a class="about-official about__left" href="#">Посетить оффициальный сайт</a>
                </v-flex>
                <v-flex xs3 class="hidden-md-and-down">
                  <p class="about__header text-md-left low-font">Внимание! <span class="content__subheader">акция</span></p>
                  <div class="stock-wrapper">
                    <div class="stock">
                      <div class="stock__rocwell-banner">
                        <v-layout row wrap>
                          <v-flex xs4 class="stock__pr">
                            <span>Скидка</span>
                            15%
                          </v-flex>
                          <v-flex xs8 class="stock__desc text-xs-left">
                            Поилки для кур rocwell
                          </v-flex>
                        </v-layout>
                      </div>
                      <div class="stock__rocwell-banner--footer">
                        <span class="stock__price">148 80</span> руб.
                        <a class="stock__btn" href="#">Подробнее</a>
                      </div>
                    </div>
                  </div>
                </v-flex>
              </v-layout>
            </v-flex>
          </div>
        </v-content>
      </div>
    </div>
  </div>
  <div class="delivery-wrapper">
    <div class="delivery">
    <v-content>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6 xl6 >
            <v-layout row wrap>
              <v-flex xs11 sm8 xl8>
                <p class="delivery__header text-xs-left">Новинки <span class="delivery__subheader">каталога</span></p>
              </v-flex>
              <v-flex xs5 sm4 xl4 class="text-md-right hidden-sm-and-down">
                <a class="delivery__button" href="#">В каталог <v-icon color="green darken-2" medium>keyboard_arrow_right</v-icon></a>
              </v-flex>
              <v-flex xs10 sm6 md10 lg12 class="text-xs-left">
                @foreach($ourProducts as $product)
                  <div class="product-wrapper">
                    <img class="product__new-label" src="{{asset('images/product-new-label.png')}}"/>
                    <img class="product__new-label-coal" src="{{asset('images/product-new-label-coal.png')}}"/>
                    <div class="product text-xs-center" align="center">
                      <div class="special-product__header text-xs-center">
                        <a href="/catalog/detail/{{$product->url_key}}">
                          {{str_limit($product->title, $limit = 50, $end="...")}}
                        </a>
                      </div>
                      <div class="special-product__img">
                        <v-layout aligin-center row wrap>
                          <a href="#" class="img-shadow">
                            @if($product->files->count()>0)
                              @foreach($product->files as $fileRecord)
                                @foreach($fileRecord->config as $files)
                                  @foreach($files as $key => $file)
                                    @if($key == 'medium')
                                      <img src="/storage/{{$file['filename']}}"/>
                                    @endif
                                  @endforeach
                                @endforeach
                                @break
                              @endforeach
                            @else
                              <img src="{{asset('images/no-image-medium.png')}}"/>
                            @endif
                          </a>
                        </v-layout>
                      </div>
                      <div class="special-product__desc text-xs-center">Сделан на заказ</div>
                      <v-layout col wrap class="special-product__mcart">
                        <v-flex xs8 class="special-product__price text-xs-center">
                          <span class="old-price">{{$product->price}}</span> руб.<br>
                          <span class="current-price">{{$product->price}}</span> <span class="rub">руб.</span>
                        </v-flex>
                        <v-flex xs4 class="special-product__cart">
                          <img @click="addCart({{$product->id}})" src="{{asset('images/product-cart.png')}}"/>
                        </v-flex>
                      </v-layout>
                    </div>
                  </div>
                @endforeach
              </v-flex>
            </v-layout>
          </v-flex>
          <v-flex class="delivery__left" xs12 sm12 md4 lg6 xl6>
            <v-layout row wrap>
              <v-flex xs10 sm10 md10 lg10 xl10>
                <p class="delivery__header text-xs-left">Наши <span class="delivery__subheader">бренды</span></p>
                <div class="brands">
                  <div class="brands__content">
                    <img src="{{asset('images/multifan.png')}}"/>
                  </div>
                  <div class="brands__content">
                    <img src="{{asset('images/roxell.png')}}"/>
                  </div>
                  <div class="brands__content">
                    <img src="{{asset('images/munters.png')}}"/>
                  </div>
                </div>
              </v-flex>
              <v-flex xs10 sm10 md10 lg10 xl10>
                <p class="delivery__header text-xs-left">Доставка и <span class="delivery__subheader">оплата</span></p>
              </v-flex>
              <v-flex xs11 sm5 md8 lg12 xl12 class="delivery__desc text-xs-left text-xs-left text-md-left">
                Узнать подробнее об условиях доставки Вы можете при оформлении заказа у нашего специалиста по телефону
                <span class="delivery__tel">+7 (495) 780-47-96</span> или сделать запрос по электронной почте
              </v-flex>
              <v-flex xs12>
                <v-layout row wrap>
                  <v-flex xs12 sm12 md6 class="text-md-left">
                    <v-layout row wrap>
                      <v-flex xs3>
                        <img align="left" src="{{asset('images/delivery-circle-1.png')}}"/>
                      </v-flex>
                      <v-flex xs3 md9 class="text-xs-left">
                        <span class="deliverty_tabl">Оплата производиться <br> по безналичному расчету.</span>
                      </v-flex>
                    </v-layout>
                  </v-flex>
                  <v-flex xs12 sm12 md6  class="text-md-left">
                    <v-layout row wrap>
                      <v-flex xs3>
                        <img align="left" src="{{asset('images/delivery-circle-2.png')}}"/>
                      </v-flex>
                      <v-flex xs6 md9 class="text-xs-left">
                        <span class="deliverty_tabl">Возможна оплата наличными при доставке на объект Заказчика</span>
                      </v-flex>
                    </v-layout>
                  </v-flex>
                </v-layout>
              </v-flex>
            </v-layout>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-content>
    </div>
  </div>
@endsection