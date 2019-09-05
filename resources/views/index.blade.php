@extends('layouts.master')

@section('title', 'Купить '.config('info.site_name').' по доступным ценам')
@section('meta-description', 'Купить '.config('info.site_name').' высокого качества, производителей Lubing, Barbieri')
@section('meta-keywords', config('info.keywords'))

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
          <!--<v-flex offset-xs3 xs6 class="hidden-md-and-down">
            <p class="content__header text-md-left">Наши акции и <span class="content__subheader">спецпредложения</span></p>
            <div class="banner"></div>
          </v-flex>
          <v-flex xs3 px-5 class="text-md-right hidden-md-and-down">
            <a class="content__buttom" href="#">Все акции <v-icon color="yellow darken-2" medium>keyboard_arrow_right</v-icon></a>
          </v-flex>
          <v-flex class="text-md-left hidden-md-and-down" offset-md3 xs9><img class="content__banner" src="{{asset('images/banner.png')}}"/></v-flex>-->
          <v-flex  offset-md3 xs8 md6>
            <p class="content__header text-sm-left">Рекомендуемые <span class="content__subheader hidden-sm-and-down">товары</span></p>
            <div class="banner"></div>
          </v-flex>
          <v-flex xs3 px-5 class="text-md-right hidden-xs-only">
            <!--<a class="content__buttom" href="#">В каталог <v-icon color="yellow darken-2" medium>keyboard_arrow_right</v-icon></a>-->
          </v-flex>
          <v-flex class="text-md-center" offset-md3 offset-xs1 lg9 md8 sm9 xs10>
            <leader-slider :perpage=3 url="/products/special" :per-custom="[[200, 1], [480, 1], [720, 2], [960, 2], [1280, 3]]">
              @include('product')
            </leader-slider>
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
                  <v-flex class="about__left" xs12 sm12 md12>
                    Наша компания предлагает огромный выбор спецоборудования для элеваторов, мельниц и комбикормовых заводов. Клиентами компании являются птицефабрики, зерноперерабатывающие организации и многие другие аграрные предприятия.
                  </v-flex>
                  <v-flex class="about__left about__cit" hidden-sm-and-down>
                    Главная задача нашей компании – максимальное расширение ассортимента и пополнение базы постоянных клиентов. Мы не ставим цель получить большую разовую прибыль. Мы выстраиваем с клиентами долгосрочные и взаимовыгодные отношения, в полном объеме выполняя взятые на себя обязательства.
                  </v-flex>
                  <!--<a class="about-official about__left" href="#">Посетить официальный сайт</a>-->
                </v-flex>
                <v-flex xs3 class="hidden-md-and-down">
                  <p class="about__header text-md-left low-font">Внимание! <span class="content__subheader">акция</span></p>
                  <div class="stock-wrapper">
                    <div class="stock stock__img">
                      <div class="stock__rocwell-banner">
                        <v-layout row wrap>
                          <v-flex xs12 class="stock__desc text-xs-left">
                            Ленты пометоудаления
                          </v-flex>
                        </v-layout>
                      </div>
                      <div class="stock__rocwell-banner--footer">
                        <v-layout row wrap>
                          <v-flex xs6 class="stock__price">
                            <!--148,80 <span style="color: white; font-size: 0.6em;">руб.</span>-->
                          </v-flex>
                          <v-flex xs6 pa-2>
                            <a class="stock__btn" href="/catalog/detail/lenta-pometoudaleniya-polipropilenovaya">Подробнее</a>
                          </v-flex>
                        </v-layout>
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
                <a class="delivery__button" href="/sale">В каталог <v-icon color="green darken-2" medium>keyboard_arrow_right</v-icon></a>
              </v-flex>
              <v-flex xs10 sm6 md10 lg12 class="text-xs-left">
                <leader-slider :perpage=2 url="/products/new" :per-custom="[[200, 1], [480, 1], [720, 2], [960, 3], [1280, 3]]">
              </v-flex>
            </v-layout>
          </v-flex>
          <v-flex class="delivery__left" xs12 sm12 md4 lg6 xl6>
            <v-layout row wrap>
              <v-flex xs10 sm10 md10 lg10 xl10 hidden-sm-and-down>
                <p class="delivery__header text-xs-left">Наши <span class="delivery__subheader">бренды</span></p>
                <div class="brands">
                  <div class="brands__content">
                    <img src="{{asset('images/lubing.gif')}}"/>
                  </div>
                  <div class="brands__content">
                    <img src="{{asset('images/barbiery.png')}}"/>
                  </div>
                  <!--<div class="brands__content">
                    <img src="{{asset('images/munters.png')}}"/>
                  </div>-->
                </div>
              </v-flex>
              <v-flex pa-2 xs12 sm12 md10 lg10 xl10>
                <p class="delivery__header text-xs-left">Доставка и <span class="delivery__subheader">оплата</span></p>
              </v-flex>
              <v-flex pa-2 xs12 sm12 md8 lg12 xl12 class="delivery__desc text-xs-left text-xs-left text-md-left">
                <p>
                  Осуществляется отправка товара через транспортные компании «Деловые линии», «ПЭК», «КИТ», «Байкал-Сервис».
                </p>
                <p>
                  Также продукцию можно забрать самовывозом с нашего склада<br> в <a href="/delivery" style="color: green; text-decoration: none; text-align: bold;">г. Старая Купавна ул. Дорожная 16 А (Ногинский район)</a>
                </p>
                <!--<span class="delivery__tel">+7 (495) 780-47-96</span> или сделать запрос по электронной почте-->
              </v-flex>
              <!--<v-flex xs12>
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
                  </v-flex>-->
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