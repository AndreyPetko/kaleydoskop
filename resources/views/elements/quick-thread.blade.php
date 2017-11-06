<div id="quick-thread">
  <div id="close-quick-thread">X</div>
  <h4>Быстрый заказ ниток</h4>
  <p style="line-height: 40px;">Выберите количество нужных ниток, затем нажмите кнопку "В корзину"</p>
  <form action="/add-threads-to-card" method="POST">
    {{ csrf_field() }}
    <div class="quick-thred-content">
      @foreach($products as $product)
      <div class="quick-thread-item">
        <p>{{ $product->name }}</p>
        <input type="number" name="products[{{$product->id}}]">
      </div>
      @endforeach
    </div>
    <div class="clear"></div>
    <div id="quick-thread-submit">
      <button type="reset" id="quick-reset">
        <div class="item-buy-image">
          <img src="http://www.kaleydoskop-vishivki.com.ua/site/images/refresh-icon-green.png" alt="">
        </div>
         Очистить
      </button>
      <button type="submit">
       <div class="item-buy-image">
        <img src="http://www.kaleydoskop-vishivki.com.ua/site/images/icon-cart-main.png" alt="">
      </div>
      В корзину
    </button>
  </div>
</form>
</div>