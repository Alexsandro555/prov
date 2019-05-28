@foreach($products as $product)
  <div class="product-wrapper">
    <div class="product">
      <div class="product-image-wrapper">
        <div class="product-image" @click="goToPage('/catalog/detail/{{$product->url_key}}')">
          @if($product->productCategory && $product->productCategory->files->count()>0)
              @foreach($product->productCategory->files->random()->config as $filesItem)
                @foreach($filesItem as $key => $fileItem)
                  @if($key == 'medium')
                    <img src="/storage/{{$fileItem['filename']}}"/>
                  @endif
                @endforeach
              @endforeach
          @elseif($product->typeProduct && $product->typeProduct->files->count()>0)
              @foreach($product->typeProduct->files->random()->config as $filesItem)
                @foreach($filesItem as $key => $fileItem)
                  @if($key == 'medium')
                    <img src="/storage/{{$fileItem['filename']}}"/>
                  @endif
                @endforeach
              @endforeach
          @elseif($product->lineProduct && $product->lineProduct->files->count()>0)
              @foreach($product->lineProduct->files->random()->config as $filesItem)
                @foreach($filesItem as $key => $fileItem)
                  @if($key == 'medium')
                    <img src="/storage/{{$fileItem['filename']}}"/>
                  @endif
                @endforeach
              @endforeach
          @elseif($product->files->count()>0)
              @foreach($product->files->random()->config as $filesItem)
                @foreach($filesItem as $key => $fileItem)
                  @if($key == 'medium')
                    <img src="/storage/{{$fileItem['filename']}}"/>
                  @endif
                @endforeach
              @endforeach
          @else
            <img src="{{asset('images/no-image-medium.png')}}"/>
          @endif
        </div>
      </div>
      <div class="product__title">
        <a href="/catalog/detail/{{$product->url_key}}">
          {{str_limit($product->title, $limit = 27, $end="...")}}
        </a>
      </div>
      <v-layout row wrap>
        <v-flex xs8 text-xs-center>
          <br>
          <!--<span class="product-old-price">{{$product->price}} руб.</span><br>-->
          <span class="product-price-wrapper">
                    <span class="product-price">{{$product->price}}</span> руб.</span>
        </v-flex>
        <v-flex xs4>
          <img @click="addCart({{$product->id}})" src="{{asset('images/btn-sale.png')}}"/>
        </v-flex>
      </v-layout>
    </div>
  </div>
@endforeach


