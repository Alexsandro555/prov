@foreach($products as $product)
  <div class="special-product-wrapper">
    <div class="special-product text-xs-center" align="center">
      <div class="special-product__header text-xs-center">
        <a href="/catalog/detail/{{$product->url_key}}">
          {{str_limit($product->title, $limit = 27, $end="...")}}
        </a>
      </div>
      <div class="special-product__img">
        <v-layout fill-height text-xs-center>
          @if($product->productCategory && $product->productCategory->files->count()>0)
            @foreach($product->productCategory->files->random()->config as $filesItem)
              @foreach($filesItem as $key => $fileItem)
                @if($key == 'medium')
                  <img src="/storage/{{$fileItem['filename']}}" style="margin: 0px auto;"/>
                @endif
              @endforeach
            @endforeach
          @elseif($product->typeProduct && $product->typeProduct->files->count()>0)
            @foreach($product->typeProduct->files->random()->config as $filesItem)
              @foreach($filesItem as $key => $fileItem)
                @if($key == 'medium')
                  <img src="/storage/{{$fileItem['filename']}}" style="margin: 0px auto;"/>
                @endif
              @endforeach
            @endforeach
          @elseif($product->lineProduct && $product->lineProduct->files->count()>0)
            @foreach($product->lineProduct->files->random()->config as $filesItem)
              @foreach($filesItem as $key => $fileItem)
                @if($key == 'medium')
                  <img src="/storage/{{$fileItem['filename']}}" style="margin: 0px auto;"/>
                @endif
              @endforeach
            @endforeach
          @elseif($product->files->count()>0)
            @foreach($product->files->random()->config as $filesItem)
              @foreach($filesItem as $key => $fileItem)
                @if($key == 'medium')
                  <img src="/storage/{{$fileItem['filename']}}" style="margin: 0px auto;"/>
                @endif
              @endforeach
            @endforeach
          @else
            <img src="{{asset('images/no-image-medium.png')}}" style="margin: 0px auto;"/>
          @endif
        </v-layout>
      </div>
      <div class="special-product__desc text-xs-center">Сделан на заказ</div>
      <v-layout col wrap class="special-product__mcart">
        <v-flex xs8 class="special-product__price text-xs-center">
          <!--<span class="old-price">145 800</span> руб.<br>-->
          @if($product->need_order)
            <span class="current-price">{{$product->price}}</span> <span class="rub">руб.</span>
          @else
            <a @click="discoverDiscount(`Добрый день! \nПрошу сообщить стоимость и наличие {{$product->title}}. \nСпасибо!`)" class="product-order-req" href="#">Запросить цену</a>
          @endif
        </v-flex>
        <v-flex xs4 class="special-product__cart">
          <img @click="addCart({{$product->id}})" src="{{asset('images/product-cart.png')}}"/>
        </v-flex>
      </v-layout>
    </div>
  </div>
@endforeach


