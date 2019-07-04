<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="{{asset('css/vuetify.min.css')}}">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{mix('css/style.css')}}">
  @yield('view.style')
  <title>@yield('title')</title>
</head>
<body>
<div id="app" v-cloak>
  <span class="v-cloak--block"></span>
  <v-app class="v-cloak--hidden leader">
    <v-container fluid grid-list-xs text-xs-center>
      <v-layout column wrap>
          <header ref="header" :class="{header: true, chickens: section===1, cows: section===2, pigs: section===3, rams:section===4, 'main-layout': section===0}">
              <div class="header-menu">
                <div class="wrapper">
                  <v-layout row wrap>
                    <v-flex xs1 class="hidden-md-and-up">
                      <navigation-menu/>
                    </v-flex>
                    <v-flex xl4 lg4 md5 sm7 xs6 class="hidden-sm-and-down">
                      <v-layout row wrap>
                        <v-list class="top-menu text-xs-left text-lg-left">
                          <v-list-tile class="top-menu__item">
                            <a class="header-menu__link"  href="/about">
                              о компании
                            </a>
                          </v-list-tile>
                          <v-list-tile class="top-menu__item">
                            <a class="header-menu__link"  href="/article/list">статьи</a>
                          </v-list-tile>
                          <v-list-tile class="top-menu__item">
                            <a class="header-menu__link"  href="/sale">Акции</a>
                          </v-list-tile>
                        </v-list>
                      </v-layout>
                    </v-flex>
                    <v-flex xl2 lg2 md2>
                      <a href="/" @click="changeSlide('main')"><img src="{{asset('images/logo-layer.png')}}"/></a>
                    </v-flex>
                    <v-flex xs2 hidden-md-and-up justify-center>
                      <v-menu  :close-on-content-click="false" offset-x>
                        <template slot="activator">
                          <img class="find" src="{{asset('images/find.png')}}"/>
                        </template>
                        <v-list>
                          <v-list-tile>
                            <v-text-field name="find" label="Введите поисковый запрос"  @keyup.enter="search"  v-model="searchText"></v-text-field>
                          </v-list-tile>
                        </v-list>
                      </v-menu>
                    </v-flex>
                    <v-flex xl6 lg6 md5 sm5 xs6 class="hidden-sm-and-down">
                      <v-layout row wrap>
                        <v-flex md12 lg8 xl8 class="text-md-center">
                          <v-list class="top-menu text-xs-left text-md-center text-sm-left text-lg-center">
                            <v-list-tile class="top-menu__item"><a class="header-menu__link"  href="/delivery">доставка и оплата</a></v-list-tile>
                            <v-list-tile class="top-menu__item"><a class="header-menu__link"  href="/contacts">контакты</a></v-list-tile>
                          </v-list>
                        </v-flex>
                        <v-flex xs4 class="hidden-md-and-down">
                          <v-layout row wrap>
                            <v-flex xs10>
                              <cart-widget>
                                <template slot-scope="{count, total}">
                                  <div class="cart-widget">
                                    <table>
                                      <tbody>
                                      <tr>
                                        <td rowspan="2"><a href="/cart"><img class="cart__img" src="/images/cart.png"/></a></td>
                                        <td><span class="cart__col-yell">@{{count}}</span> товара на</td>
                                      </tr>
                                      <tr>
                                        <td><span class="cart__col-yell">@{{total}}</span> руб.</td>
                                      </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </template>
                              </cart-widget>
                            </v-flex>
                            <v-flex xs2 justify-center>
                              <v-menu  :close-on-content-click="false" offset-x>
                                <template slot="activator">
                                  <img class="find" src="{{asset('images/find.png')}}"/>
                                </template>
                                <v-list>
                                  <v-list-tile>
                                    <v-text-field name="find" label="Введите поисковый запрос"  @keyup.enter="search"  v-model="searchText"></v-text-field>
                                  </v-list-tile>
                                </v-list>
                              </v-menu>
                            </v-flex>
                          </v-layout>
                        </v-flex>
                      </v-layout>
                    </v-flex>
                  </v-layout>
                </v-flex>
              </div>
            <!--<v-layout align-center justify-start column fill-height>
              <v-flex xs12 text-align-center>
                <a href="/"><img src="{{asset('images/logo-layer.png')}}"/></a>
              </v-flex>
            </v-layout>-->
              <div class="wrapper header-slogan">
                <v-flex sm12>
                  <v-layout row wrap>
                    <v-flex sm4 class="hidden-md-and-down">
                      <div class="main-slogan">
                        Инновационные <span class="sub-slogan">системы кормления</span><br>
                        <span class="main-slogan__from">от европейских производителей</span>
                      </div>
                    </v-flex>
                    <v-flex sm3 offset-sm3 class="hidden-md-and-down">
                      <div class="phone text-xs-right">
                        Работаем с <b>{{config('info.time_start')}}</b> до <b>{{config('info.time_end')}}</b><br>
                        <span class="phone__number">{{config('info.telephone')}}</span><br>
                        <a class="phone__callback" @click="showCallback" href="#">Заказать звонок</a>
                      </div>
                    </v-flex>
                  </v-layout>
                </v-flex>
              </div>
              <div class="wrapper">
                <div class="animal-panel hidden-md-and-down">
                  <a href="#"><img :class="{borderSel: section===1}" @click.stop="changeSlide('chickens')" src="{{asset('images/chicken-img-panel.png')}}"/></a>
                  <a href="#"><img :class="{borderSel: section===3}" @click.stop="changeSlide('pigs')" src="{{asset('images/pig-img-panel.png')}}"/></a>
                  <a href="#"><img :class="{borderSel: section===2}" @click.stop="changeSlide('cows')" src="{{asset('images/cow-img-panel.png')}}"/></a>
                  <a href="#"><img :class="{borderSel: section===4}" @click.stop="changeSlide('rams')" src="{{asset('images/bar-img-panel.png')}}"/></a>
                </div>
                @yield('breadcrumbs')
              </div>
            <!--<img class="header__img" src="{{asset('images/header-layer.png')}}"/>-->
          </header>
          <div class="content-wrapper-top"></div>
          @yield('menu')
          @yield('content')
          <footer class="footer">
            <div class="footer-wrapper">
              <v-layout row wrap>
                <v-flex xs12 class="hidden-sm-and-down">
                  <v-layout row wrap>
                    <v-flex xs9>
                      <v-list class="footer-top-menu text-xs-left">
                        <v-list-tile class="footer-top-menu__item"><a class="header-menu__link"  href="/about">О компании</a></v-list-tile>
                        <v-list-tile class="footer-top-menu__item"><a class="header-menu__link"  href="/news/list">Новости</a></v-list-tile>
                        <v-list-tile class="footer-top-menu__item"><a class="header-menu__link"  href="/sale">Акции</a></v-list-tile>
                        <v-list-tile class="footer-top-menu__item"><a class="header-menu__link"  href="/delivery">Доставка и оплата</a></v-list-tile>
                        <v-list-tile class="footer-top-menu__item"><a class="header-menu__link"  href="/contacts">Контакты</a></v-list-tile>
                      </v-list>
                    </v-flex>
                    <v-flex xs3>
                      <img class="footer__sicial-icons" src="{{asset('images/footer-social-icons.png')}}"/>
                    </v-flex>
                  </v-layout>
                </v-flex>
                <v-flex xs12 class="footer__content">
                  <v-layout row wrap>
                    <v-flex xs6 class="footer__menu hidden-sm-and-down">
                      <v-layout row wrap>
                        @foreach($typeProducts->chunk(7) as $chunkTypeProduct)
                          <v-flex xs10 sm6 md4 class="text-xs-left">
                            <v-list>
                              @foreach($chunkTypeProduct as $typeProduct)
                                <v-list-tile>
                                  <a href="/catalog/{{$typeProduct->product_category->url_key}}/{{$typeProduct->url_key}}">{{$typeProduct->title}}</a>
                                </v-list-tile>
                              @endforeach
                            </v-list>
                          </v-flex>
                        @endforeach
                      </v-layout>
                    </v-flex>
                    <v-flex xs2 class="hidden-sm-and-down">
                      <img class="footer__chicken" src="{{asset('images/footer-chicken.png')}}"/>
                    </v-flex>
                    <v-flex xs11 offset-xs1 sm11 md3 class="text-xs-left text-md-right">
                      <v-layout column wrap>
                        <v-flex xs8>
                          <span class="footer__phone footer-right">
                              Работаем с <b>{{config('info.time_start')}}</b> до <b>{{config('info.time_end')}}</b><br>
                              <span class="phone__number">{{config('info.telephone')}}</span><br>
                              <a class="phone__callback text-xs-center" @click="showCallback" href="#">Заказать звонок</a>
                          </span>
                        </v-flex>
                        <v-flex xs4 class="footer__address text-xs-right">
                          <v-flex offset-md3 class="text-xs-right footer__address--margbot10 footer-right">
                            <a class="text-xs-center footer__mail" href="/admin">Личный кабинет</a><br>
                            <span>
                                 <img align="top" src="{{asset('images/footer-mail-img.png')}}"/>
                                 <span class="footer__mail"> {{config('info.email')}}</span>
                            </span><br>
                            <span>
                              <img align="top" src="{{asset('images/footer-map-marker-img.png')}}"/>
                              {{config('info.address')}}
                            </span>
                          </v-flex>
                          <v-flex xs12 class="text-xs-right">
                            <v-layout row wrap>
                              <v-flex xs6>
                                <img align="middle" class="footer__logo" src="{{asset('images/logo-small.png')}}"/>&nbsp;&nbsp;&nbsp;
                              </v-flex>
                              <v-flex xs5 text-xs-right>
                                <span>© Copyright 2019</span><br>
                              </v-flex>
                            </v-layout>
                          </v-flex>
                        </v-flex>
                      </v-layout>
                    </v-flex>
                  </v-layout>
                </v-flex>
              </v-layout>
            </div>
          </footer>
      </v-layout>
    </v-container>
    <cart-modal></cart-modal>
    <callback/>
  </v-app>
</div>
<script src="{{mix('/js/main.js')}}" type="application/javascript"></script>
</body>
</html>