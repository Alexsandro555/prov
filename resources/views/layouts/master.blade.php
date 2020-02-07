<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="@yield('meta-description')">
  <meta name="keywords" content="@yield('meta-keywords')">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{mix('css/style.css')}}">
  @yield('view.style')
  <title>@yield('title')</title>
</head>
<body>
<div id="app" v-cloak>
  <span class="v-cloak--block"></span>
  <v-app class="v-cloak--hidden leader">
    <v-container fluid class="hidden-md-and-down pa-0 ma-0">
      <header ref="header" :class="getHeaderClass">
        <div class="header-menu">
          <v-row class="wrapper">


            <!----------------------LEFT TOP MENU----------------------------------->
            <v-col cols="7" lg="3" style="min-width: 340px;" class="hidden-sm-and-down ma-0 pa-0">
              <v-row>
                <v-col tab="v-list" cols="12" id="top-menu" class="ma-0 pa-0 text-left">
                  <v-list-item class="top-menu--item"><a href="/about">о компании</a></v-list-item>
                  <v-list-item class="top-menu--item"><a class="header-menu__link" href="/article/list">статьи</a></v-list-item>
                  <v-list-item class="top-menu--item"><a class="header-menu__link" href="/sale">акции</a></v-list-item>
                </v-col>
              </v-row>
            </v-col>
            <!----------------------END LEFT TOP MENU------------------------------->





            <!----------------------LOGO--------------------------------------------->
            <v-col cols="2" style="min-width:250px;" class="ma-0 pa-0" style="margin-left: 40px;">
              <a class="logo" href="/"></a>
            </v-col>
            <!----------------------END LOGO----------------------------------------->




            <!----------------------RIGHT MENU---------------------------------------->
            <v-col cols="3" lg="6"  class="text-right ma-0 pa-0">
              <v-row>
                <v-col cols="10" lg="6" class="ma-0 pa-0">
                  <v-row>
                    <v-col tab="v-list" id="top-menu">
                      <v-list-item class="top-menu--item"><a href="/delivery">доставка и оплата</a></v-list-item>
                      <v-list-item class="top-menu--item"><a class="header-menu__link" href="/contacts">контакты</a></v-list-item>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="4">
                  <!--<cart-widget>
                            <template slot-scope="{count, total}">
                              <div class="cart-widget">
                                <table>
                                  <tbody>
                                  <tr>
                                    <td rowspan="2"><a href="/cart"><img onclick="ym(54321909,'reachGoal','cartClick74951233321'); gtag('event', 'click', {'event_category': 'cart','event_label': 'cart click main page','value': 1}); return true;" class="cart__img" src="/images/cart.png"/></a>
                                    </td>
                                    <td><span class="cart__col-yell">@{{count}}</span> товара на</td>
                                  </tr>
                                  <tr>
                                    <td><span class="cart__col-yell">@{{total}}</span> руб.</td>
                                  </tr>
                                  </tbody>
                                </table>
                              </div>
                            </template>
                          </cart-widget>-->
                </v-col>
                <v-col cols="2" class="pa-0 ma-0">
                  <v-menu :close-on-content-click="false" offset-x>
                    <template v-slot="activator">
                      <img class="find" src="{{asset('images/find.png')}}"/>
                    </template>
                    <v-list>
                      <v-list-item>
                        <v-text-field name="find" label="Введите поисковый запрос" @keyup.enter="search" v-model="searchText"></v-text-field>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </v-col>
              </v-row>
            </v-col>
            <!--------------------------END RIGHT MENU----------------------------->




            <!--------------------------СЛОГАН-------------------------------------->
            <v-row class="wrapper header-slogan text-left">
              <v-flex sm12>
                <v-layout row wrap>
                  <v-col cols="4" class="hidden-md-and-down">
                    <div class="main-slogan">
                      Инновационные <span class="sub-slogan">системы кормления</span><br>
                      <span class="main-slogan__from">от европейских производителей</span>
                    </div>
                  </v-col>
                  <v-col cols="3" offset-sm="3">
                    <div class="phone text-right">
                      Работаем с <b>{{config('info.time_start')}}</b> до <b>{{config('info.time_end')}}</b><br>
                      <a onclick="ym(54321909,'reachGoal','phoneClick74951233321'); gtag('event', 'click', {'event_category': 'phone','event_label': 'click phone header','value': 5}); return true;" class="phone__number" href="tel: {{config('info.telephone')}}">{{config('info.telephone')}}</a><br>
                      <a class="phone__callback" onclick="ym(54321909,'reachGoal','callback74951233321'); gtag('event', 'click', {'event_category': 'callback','event_label': 'click callback header','value': 2}); return true;" @click="showCallback" href="#">Заказать звонок</a>
                    </div>
                  </v-col>
                </v-layout>
              </v-flex>
            </v-row>
            <!---------------------------КОНЕЦ СЛОГАН--------------------------------->




          </v-row>
        </div>
        <div class="sections">
          <section-buttons/>
        </div>
      </header>


    @yield('menu')
    @yield('content')

    <!--------------------FOOTER--------------------->
      <footer>
        <div class="footer-wrapper">
          <v-row>

            <!--------------TOP MENU--------------------------->
            <v-col tab="v-list" cols="9" id="top-menu">
              <v-list-item class="top-menu--item"><a href="/about">О компании</a></v-list-item>
              <v-list-item class="top-menu--item"><a href="/news/list">Новости</a></v-list-item>
              <v-list-item class="top-menu--item"><a href="/sale">Акции</a></v-list-item>
              <v-list-item class="top-menu--item"><a href="/delivery">Доставка и оплата</a></v-list-item>
              <v-list-item class="top-menu--item"><a href="/contacts">Контакты</a></v-list-item>
            </v-col>
            <!--------------END TOP MENU--------------------------->


            <!--------------FOOTER SOCIAL----------------------------->
            <v-col cols="3">
              <img src="{{asset('images/footer-social-icons.png')}}"/>
            </v-col>
            <!--------------END FOOTER SOCIAL----------------------------->




            <!--------------FOOTER CONTENT----------------------------->
            <v-col cols="12">
              <v-row>



                <!----------FOOTER MENU----------------------------------->
                <v-col cols="5">
                  <v-row id="footer__menu">
                    @foreach($typeProducts->chunk(7) as $chunkTypeProduct)
                      <v-col cols="4"class="text-xs-left">
                        <v-list class="footer-list">
                          @foreach($chunkTypeProduct as $typeProduct)
                            <v-list-item class="footer-item"><a href="/catalog/{{$typeProduct->productCategory->url_key}}/{{$typeProduct->url_key}}">{{$typeProduct->title}}</a></v-list-item>
                          @endforeach
                        </v-list>
                      </v-col>
                    @endforeach
                  </v-row>
                </v-col>
                <!----------END FOOTER MENU----------------------------------->


                <!----------FOOTER LOGO--------------------------------------->
                <v-col cols="2">
                  <img class="footer__chicken" src="{{asset('images/footer-chicken.png')}}"/>
                </v-col>
                <!----------END FOOTER LOGO------------------------------------>


                <v-col cols="5" offset-xs="1" class="footer-info text-xs-left text-md-right">
                  <v-row>



                    <!-----TELEPHONE------------------------------------------>
                    <v-col cols="7">
                      <span class="footer__phone footer-right">
                        Работаем с <b>{{config('info.time_start')}}</b> до <b>{{config('info.time_end')}}</b><br>
                        <a onclick="ym(54321909,'reachGoal','phoneClick74951233321'); gtag('event', 'click', {'event_category': 'phone','event_label': 'click phone footer','value': 5}); return true;" class="phone__number" href="tel: {{config('info.telephone')}}">{{config('info.telephone')}}</a><br>
                        <a onclick="ym(54321909,'reachGoal','callback74951233321'); gtag('event', 'click', {'event_category': 'callback','event_label': 'click callback footer','value': 2}); return true;" class="phone__callback text-xs-center" @click="showCallback"
                           href="#">Заказать звонок</a>
                      </span>
                    </v-col>
                    <!-----END TELEPHONE--------------------------------------->


                    <!------FOOTER ADMIN--------------------------------------->
                    <v-col cols="5" class="footer__address text-xs-right">
                      <v-col offset-md="2" cols="12" class="text-xs-right footer__address--margbot10 footer-right ma-0 pa-0">
                        <a class="text-xs-center footer__mail" href="/admin">Личный кабинет</a><br>
                        <span>
                          <img align="top" src="{{asset('images/footer-mail-img.png')}}"/>
                          <a class="footer__mail" onclick="ym(54321909,'reachGoal','mailClick74951233321'); gtag('event', 'click', {'event_category': 'email','event_label': 'click email footer','value': 5}); return true;" href="mailto:{{config('info.manager_email')}}">{{config('info.manager_email')}}</a>
                        </span><br>
                        <span>
                          <img align="top" src="{{asset('images/footer-map-marker-img.png')}}"/>
                          {{config('info.address')}}
                        </span>
                      </v-col>
                      <v-col cols="12" class="text-xs-right">
                        <v-row>
                          <v-col cols="12"><img align="middle" class="footer__logo" src="{{asset('images/logo-small.png')}}"/>&nbsp;&nbsp;&nbsp;</v-col>
                          <v-col cols="12" text-xs-right>
                            <span>© Copyright 2019</span><br>
                          </v-col>
                        </v-row>
                      </v-col>
                    </v-col>
                  </v-row>
                </v-col>
              </v-row>
            </v-col>
            <!--------------END FOOTER CONTENT----------------------------->





          </v-row>
        </div>
      </footer>
      <!--------------------END FOOTER--------------------->






    </v-container>

    <!--------------------------------mobile-version------------------------------------->
    <v-container fluid class="hidden-lg-and-up pa-0 ma-0">
      <v-row no-gutters>
        <section class="mobile__header">
          <v-container fill-height py-0 ma-0>
            <v-row no-gutters class="justify-center align-center">
              <v-col cols="3" class="text-left px-3">
                <v-btn dark @click="open" class="navigation-btn" text icon>
                  <v-icon>list</v-icon> МЕНЮ
                </v-btn>
                <navigation-menu/>
              </v-col>
              <v-col cols="6">
                <v-row class="justify-center align-center">
                  <a href="/"><img src="{{asset('images/mobile-logo.png')}}"/></a>
                </v-row>
              </v-col>
              <v-col cols="3">
                <v-container px-0 fill-height justify-center align-center>
                  <v-row no-gutters>
                    <v-col class="text-right">
                      <cart-widget>
                        <template slot-scope="slotProps">
                          <a class="link-cart"  href="/cart"><v-icon color="white">shopping_cart</v-icon> @{{slotProps.count}}</a>
                        </template>
                      </cart-widget>
                    </v-col>
                  </v-row>
                </v-container>
              </v-col>
            </v-row>
          </v-container>
        </section>
        <section class="mobile-category">
          <v-container py-0 ma-0>
            <v-row class="justify-center align-center">
              <v-col px-3 cols="4" class="text-left">
                Каталог
              </v-col>
              <v-col cols="8" class="text-right">
                <v-btn @click.prevent="openCatalog" class="navigation-btn" text icon>
                  <v-icon color="#000">@{{ drawer2?'close':'list' }}</v-icon>
                </v-btn>
                <navigation-menu-category/>
              </v-col>
            </v-row>
          </v-container>
        </section>

        @yield('content')


        <v-col cols="12" class="mobile-footer">
          <v-container fill-height pa-0 ma-0>
            <v-row no-gutters class="px-1 mx-1">
              <v-col cols="6">
                <h6 class="footer__mobile-title">Контакты</h6>
                <span class="footer__phone footer-right">
                  Работаем с <b>{{config('info.time_start')}}</b> до <b>{{config('info.time_end')}}</b><br>
                  <a onclick="ym(54321909,'reachGoal','phoneClick74951233321'); gtag('event', 'click', {'event_category': 'phone','event_label': 'click phone footer','value': 5}); return true;" class="phone__number" href="tel: {{config('info.telephone')}}">{{config('info.telephone')}}</a><br>
                  <a onclick="ym(54321909,'reachGoal','callback74951233321'); gtag('event', 'click', {'event_category': 'callback','event_label': 'click callback footer','value': 2}); return true;" class="phone__callback text-xs-center" @click="showCallback" href="#">Заказать звонок</a>
                </span>
              </v-col>
              <v-col cols="6" hidden-xs-and-down text-xs-left>
                <h6 class="footer__mobile-title">Разделы</h6>
                <ul>
                  <li><a href="/about">О компании</a></li>
                  <li><a href="/news/list">Новости</a></li>
                  <li><a href="/sale">Акции</a></li>
                  <li><a href="/delivery">Доставка и оплата</a></li>
                  <li><a href="/contacts">Контакты</a></li>
                </ul><br><br>
              </v-col>
              </v-layout>
              </v-flex>
            </v-row>
          </v-container>
        </v-col>
      </v-row>
    </v-container>
    <callback/>
    <!--------------------------------end mobile-version--------------------------------->
  </v-app>
</div>

<script src="{{mix('/js/main.js')}}" type="application/javascript"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
  (function (m, e, t, r, i, k, a) {
    m[i] = m[i] || function () {
      (m[i].a = m[i].a || []).push(arguments)
    };
    m[i].l = 1 * new Date();
    k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
  })
  (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

  ym(54321909, "init", {
    clickmap: true,
    trackLinks: true,
    accurateTrackBounce: true
  });
</script>

<noscript>
  <div><img src="https://mc.yandex.ru/watch/54321909" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-149664847-1"></script>

<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }

  gtag('js', new Date());

  gtag('config', 'UA-149664847-1');
</script>

</body>
</html>