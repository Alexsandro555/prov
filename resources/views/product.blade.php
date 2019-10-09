<template slot-scope="{product, getImages, getUrl}">
  <div class="special-product-wrapper">
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
      <div class="special-product__desc text-xs-center">Уточнять наличие на складе</div>
      <v-layout col wrap class="special-product__mcart">
        <v-flex xs8 class="special-product__price text-xs-center">
          <!--<span class="old-price">145 800</span> руб.<br>-->
          <template v-if="!product.need_order">
            <span class="current-price">@{{Math.floor(product.price)}}</span> <span class="rub">руб.</span>
          </template>
          <a v-else onclick="ym(54321909,'reachGoal','requestPrice74951233321'); gtag('event', 'click', {'event_category': 'requestPrice','event_label': 'request price','value': 5}); return true;" @click="discoverDiscount(`Добрый день! \nПрошу сообщить стоимость и наличие ${product.title}.\nСпасибо!`)" class="product-order-req" href="#">Запросить цену</a>
        </v-flex>
        <v-flex v-if="!product.need_order" xs4 class="special-product__cart">
          <a :href="'/catalog/detail/'+product.url_key">
            <img src="/images/product-cart.png"/>
          </a>
        </v-flex>
      </v-layout>
    </div>
  </div>
</template>