@extends('frontend.v-2.master')
@push('style')
    {{-- <!-- Flowbite -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"
      rel="stylesheet"
    /> --}}
    <!-- Fontawesome -->
    <script
      src="https://kit.fontawesome.com/942922f9a6.js"
      crossorigin="anonymous"
    ></script>
    <!-- Slick slider -->
    <link
      rel="stylesheet"
      type="text/css"
      href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
    />
    {{-- <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                variableproduct: '#4DBD35',
              }
            },
          },
        };
      </script> --}}
@endpush

@section('title')
    Product Details
@endsection

@section('content-v2')
    <!-- Product Details -->
    <section class="container mx-auto px-2 my-6" id="product-section">
        <div class="row mx-auto justify-content-between">
            <div class="col-lg-9">
                <div class="row mx-auto justify-content-center align-items-center">
                    <!-- Product Image Slider -->
                    <div class="col-md-6">
                        <div id="carousel-product" class=" mx-auto">
                            <!-- Carousel Wrapper -->
                            <div id="slide" class="position-relative">
                                @foreach ($details->productImages as $image)
                                    <div class="mySlides">
                                        <img src="{{ asset('galleryImage/' . $image->gallery_image) }}" class="img-fluid">
                                    </div>
                                @endforeach

                                {{-- <!-- Slider Navigation -->
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="d-flex align-items-center justify-content-between">
                                       <div>
                                        <button class="prev bg-dark text-white rounded-start p-2 md-p-3 lg-p-4" onclick="plusSlides(-1)">&#10094;</button>
                                       </div>
                                      <div>
                                        <button class="next bg-dark text-white rounded-end p-2 md-p-3 lg-p-4" onclick="plusSlides(1)">&#10095;</button>
                                      </div>
                                    </div>
                                </div> --}}
                            </div>


                            <!-- Thumbnail Images -->
                            <div class="d-flex align-items-center justify-content-center mt-3">
                                @foreach ($details->productImages as $image)
                                    <div class="column">
                                        <img class="thumbnail cursor w-50" src="{{ asset('galleryImage/' . $image->gallery_image) }}" onclick="currentSlide({{ $loop->index + 1 }})" alt="gallery_image">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Product Information -->
                    <div class="col-md-6">
                        <h2 class="text-lg lg-text-2xl font-semibold text-dark">{{ $details->name }}</h2>

                        <form action="{{url('/add/to/cart/variable-details/page/'.$details->id)}}" id="addToCartForm" method="POST">
                            @csrf
                            <div class="my-4 d-flex align-items-center justify-content-center md-justify-content-start gap-3" id="buttonGroup">
                                @foreach ($details->productImages as $image)
                                    @if ($image->color != null)
                                        <button id="button" type="button" class="px-4 py-2 bg-light text-dark rounded" onclick="currentSlide({{$loop->index+1}}),ProductColor('{{$image->color}}')">{{$image->color}}</button>
                                    @endif
                                @endforeach
                                <input type="hidden" name="inputcolor" id="inputcolor" value="">
                            </div>

                            <div id="size" class="hidden sizeButtonGroups">
                                <div class="d-flex align-items-center justify-content-center lg-justify-content-start gap-2 lg-gap-4">
                                    @foreach ($details->productImages as $image)
                                       @if ($image->size != null)
                                       <button type="button" class="px-4 py-2 bg-light text-dark rounded" onclick="productSize({{ $image->price }}, '{{ $image->size }}')">{{$image->size}}</button>
                                       @endif
                                    @endforeach
                                    <input type="hidden" name="inputsize" id="inputsize" value="">
                                </div>
                            </div>

                            <div class="text-xl text-dark lg-text-3xl my-4 md-d-flex align-items-center gap-2 font-medium">
                                <p class="text-dark text-center md-text-start">
                                    <span id="price" style="font-size: 20px">
                                        @if ($details->discount_price != null)
                                            {{$details->discount_price}}
                                        @else
                                            {{$details->regular_price}}
                                        @endif
                                    </span> TK.
                                </p>
                                @if ($details->discount_price != null)
                                    <input type="hidden" id="inputPrice" name="inputPrice" value="{{$details->discount_price}}">
                                @else
                                    <input type="hidden" id="inputPrice" name="inputPrice" value="{{$details->regular_price}}">
                                @endif
                            </div>

                            <div class="my-4 d-flex align-items-center justify-content-center md-justify-content-start gap-3 mx-auto text-xl font-md">
                                {{-- <button type="button" class="quantity-btn btn btn-dark border border-dark px-2 py-1 rounded-circle">-</button>
                                <div class="quantity-display border-dark border px-4 py-1 rounded text-dark">1</div>
                                <input type="hidden" name="inputQty" id="inputQty" value="1">
                                <button type="button" class="quantity-btn btn btn-dark border border-dark px-2 py-1 rounded-circle">+</button> --}}
                                <input type="hidden" name="inputQty" id="inputQty" value="1">
                            </div>

                            <div class="my-4 gap-3 font-medium">
                                <input type="hidden" name="button_action" id="buttonAction" value="">
                                <div class="my-2">
                                    <button onclick="setButtonAction('buyNow')" class="font-medium order-btn btn py-2 w-100 lg-w-60">
                                        <i class="fa-solid fa-truck"></i> Order Now
                                    </button>
                                </div>
                            </div>

                            <div class="">
                                <button class="font-medium order-btn btn py-2 w-100 lg-w-60">
                                    <i class="fa-solid fa-phone"></i> For Call : {{$setting->phone}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!--Product details Tabs -->
                <div class="my-5 bg-white border border-gray-200 rounded-xl">
                    <!-- Tab button -->
                    <ul class="nav nav-pills flex-column flex-sm-row gap-3 px-4 mt-3 justify-content-start" id="tabContainer">
                        <li class="nav-item my-1">
                            <button class=" order-btn text-white rounded-pill" data-bs-toggle="pill" data-bs-target="#descriptionTab">Description</button>
                        </li>
                        {{-- <li class="nav-item my-1">
                            <button class="nav-link bg-gray-200 rounded-pill" data-bs-toggle="pill" data-bs-target="#policyTab">Product Policy</button>
                        </li> --}}
                    </ul>
                    <!--Description Tab content -->
                    <div class="tab-content px-2 lg-px-5">
                        <div class="tab-pane fade show active my-4" id="descriptionTab">
                            {!!$details->long_description!!}
                        </div>
                        {{-- <!-- policy tab -->
                        <div class="tab-pane fade my-4" id="policyTab">
                            {!!$details->policy!!}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <!-- js -->
    <script src="{{ asset('frontend/v-2/assets/js/playground.js') }}"></script>

   <!-- Slick slider -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script
       type="text/javascript"
       src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"
   ></script>

   <!-- flowbite -->
   {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}

    <script>
      function onSubmitForm(event) {
          event.preventDefault();

          var product_name = document.getElementById('product_name').value;
          var price = document.getElementById('price').value;
          var product_id = document.getElementById('product_id').value;
          var category = document.getElementById('category').value;

          dataLayer = window.dataLayer || [];

          dataLayer.push({
              ecommerce: null
          });
          dataLayer.push({
              event: "add_to_cart",
              ecommerce: {
                  items: [{
                      item_name: product_name,
                      item_id: product_id,
                      price: price,
                      item_brand: "Unknown",
                      item_category: category,
                      item_variant: "",
                      item_list_name: "",
                      item_list_id: "",
                      index: 0,
                      quantity: 1,
                  }]
              }
          });
          document.getElementById('addToCartForm').submit();
      }
  </script>
  <script>
      // Function to set the value of the hidden input based on the clicked button
      function setButtonAction(action) {
          document.getElementById('buttonAction').value = action;
      }
  </script>
@endpush