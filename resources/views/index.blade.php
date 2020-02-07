@extends('layouts.master')

@section('title', 'Купить '.config('info.site_name').' по доступным ценам')
@section('meta-description', 'Купить '.config('info.site_name').' высокого качества, производителей Lubing, Barbieri')
@section('meta-keywords', config('info.keywords'))

@section('menu')
 <div class="menu-wrapper wrapper">
   <div class="abs-position">
     <left-menu/>
   </div>
 </div>
@endsection

@section('content')
  <section class="content-wrapper text-xs-center">
    <div class="content">
      <v-row>
        <v-col offset-lg="3" lg="9">
          <p class="header text-sm-left">Рекомендуемые <span class="subheader hidden-sm-and-down">товары</span></p>
          <div class="banner"></div>
        </v-col>

        <!--<v-col cols="3" class="text-md-right hidden-xs-only px-5">
          <a class="content__buttom" href="#">В каталог <v-icon color="yellow darken-2" medium>keyboard_arrow_right</v-icon></a>
        </v-col>-->

        <v-col class="text-md-center" offset-lg="3" lg="9">
          <carousel :perpage=2 url="/products/special" :per-custom="[[200, 1], [480, 1], [600, 2], [960, 3], [1264, 3], [1920, 3]]">
            @include('product')
          </carousel>
        </v-col>
      </v-row>
    </div>
  </section>



  <!-------------section about----------------------->
  <section class="about-container">
    <div class="about-wrapper about--green">
      <div class="about">
        <v-container class="about__content">
          <v-row>
            <v-col cols="3" class="news hidden-sm-and-down">
              <p class="about__header text-xs-left">Новости</p>
              @foreach($news as $oneNews)
                <div class="text-xs-left news__content">
                  <span class="news__date"><span class="news__date-d">{{$oneNews->updated_at->format('d.')}}</span>{{$oneNews->updated_at->format('m.Y')}}</span><br>
                  <span class="news__header"><a
                      href="/news/{{$oneNews->url_key}}">{{$oneNews->title}}</a></span><br>
                  <v-flex xs4 sm12>
                    {{str_limit(strip_tags($oneNews->content), $limit = 37, $end="...")}}
                  </v-flex>
                </div>
              @endforeach
              <div class="text-xs-left">
                <a class="news__button" href="/news/list">Все новости</a>
              </div>
            </v-col>
            <v-col class="text-xs-left about__main-info" cols="12" md="6">
              <p class="about__header text-md-left">О компании <span class="subheader hidden-sm-and-down">и оборудовании</span>
              </p>
              <v-col class="about__left" cols="12">
                Наша компания предлагает огромный выбор спецоборудования для элеваторов, мельниц и комбикормовых
                заводов. Клиентами компании являются птицефабрики, зерноперерабатывающие организации и многие другие
                аграрные предприятия.
              </v-col>
              <v-col class="about__left about__cit" class="hidden-sm-and-down">
                Главная задача нашей компании – максимальное расширение ассортимента и пополнение базы постоянных
                клиентов. Мы не ставим цель получить большую разовую прибыль. Мы выстраиваем с клиентами
                долгосрочные и взаимовыгодные отношения, в полном объеме выполняя взятые на себя обязательства.
              </v-col>
              <!--<a class="about-official about__left" href="#">Посетить официальный сайт</a>-->
            </v-col>
            <v-col cols="3" class="hidden-md-and-down">
              <p class="about__header text-md-left low-font">Внимание! <span class="subheader">акция</span>
              </p>
              <div class="stock-wrapper">
                <div class="stock stock__img">
                  <div class="stock__rocwell-banner">
                    <v-row>
                      <v-col cols="12" class="stock__desc text-xs-left">
                        Ленты пометоудаления
                      </v-col>
                    </v-row>
                  </div>
                  <div class="stock__rocwell-banner--footer">
                    <v-row>
                      <v-col cols="6" class="stock__price">
                        <!--148,80 <span style="color: white; font-size: 0.6em;">руб.</span>-->
                      </v-col>
                      <v-col cols="6" class="pa-2">
                        <a class="main-button" href="/catalog/detail/lenta-pometoudaleniya-polipropilenovaya">Подробнее</a>
                      </v-col>
                    </v-row>
                  </div>
                </div>
              </div>
            </v-col>
          </v-row>
        </v-container>
      </div>
    </div>
  </section>
  <!-------------end section about----------------------->


  <!-------------start delivery section------------------>
  <section class="delivery-wrapper">
    <v-container class="delivery">
      <v-row no-gutter>
        <v-col cols="12" lg="6">
          <v-row>
            <v-col cols="12" md="8">
              <p class="delivery__header text-xs-left">Новинки <span class="subheader">каталога</span></p>
            </v-col>
            <v-col cols="12" md="4">
              <a class="main-button--green" href="/sale">В каталог<v-icon color="green darken-2" medium>keyboard_arrow_right</v-icon></a>
            </v-col>
            <v-col cols="10" sm="6" md="10" lg="12" class="text-xs-left">
              <carousel :perpage=2 url="/products/new" :per-custom="[[200, 1], [480, 1], [720, 2], [960, 2], [1280, 3]]">
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" md="4" lg="6">
          <v-row>
            <v-col cols="10" class="hidden-sm-and-down">
              <p class="delivery__header text-xs-left">Наши <span class="subheader">бренды</span></p>
              <div class="brands">
                <v-container>
                  <div class="brands__content">
                    <img src="{{asset('images/lubing.gif')}}"/>
                  </div>
                  <div class="brands__content">
                    <img src="{{asset('images/barbiery.png')}}"/>
                  </div>
                </v-container>
              </div>
            </v-col>
            <v-col class="pa-2" cols="12" md="10">
              <p class="delivery__header text-xs-left">Доставка и <span class="subheader">оплата</span></p>
            </v-col>
            <v-col class="pa-2" cols="12" class="delivery__desc text-xs-left text-xs-left text-md-left">
              <p>
                Осуществляется отправка товара через транспортные компании «Деловые линии», «ПЭК», «КИТ»,
                «Байкал-Сервис».
              </p>
              <p>
                Также продукцию можно забрать самовывозом с нашего склада<br> в <a href="/delivery" style="color: green; text-decoration: none; text-align: bold;">г.
                  Старая Купавна ул. Дорожная 16 А (Ногинский район)</a>
              </p>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </section>
  <!-------------end delivery section------------------>

@endsection