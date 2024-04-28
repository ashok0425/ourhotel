<!-- listing-item-container -->
                                            <div class="listing-item-container init-grid-items fl-wrap three-columns-grid">
                                                <!-- listing-item  -->
                                                <div class="listing-item has_two_column">
                                                    <article class="geodir-category-listing fl-wrap">
                                                        <div class="geodir-category-img">
                                                            <a title="{{$place->name}}" href="{{route('place_detail', $place->slug)}}"><img src="{{getImageUrl($place->thumbnail)}}" alt="{{$place->name}}"></a>

                                                            <div class="listing-avatar"><a href="author-single.html"><img src="images/avatar/1.jpg" alt=""></a>
                                                            </div>
                                                            <div class="sale-window">Sale 20%</div>
                                                            <div class="geodir-category-opt">
                                                                <div class="listing-rating card-popup-rainingvis" data-starrating2="{{number_format($place->avgReview, 1)}}"></div>
                                                                <div class="rate-class-name">
                                                                    <div class="score"><strong>Very Good</strong>({{$place->reviews_count}} {{__('reviews')}})</div>
                                                                    <span>@if($place->reviews_count)
                                                                        <span>{{number_format($place->avgReview, 1)}}</span>
                                                                        <i class="la la-star"></i>
                                                                    @endif</span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="geodir-category-content fl-wrap title-sin_item">
                                                            <div class="geodir-category-content-title fl-wrap">
                                                                <div class="geodir-category-content-title-item">
                                                                    <h3 class="title-sin_map"><a href="{{route('place_detail', $place->slug)}}" title="{{$place->name}}">{{$place->name}}</a></h3>
                                                                    <div class="geodir-category-location fl-wrap"><a href="#" class="map-item"><i class="fas fa-map-marker-alt"></i> 27th Brooklyn New York, USA</a></div>
                                                                </div>
                                                            </div>
                                                            <p>Sed interdum metus at nisi tempor laoreet. Integer gravida orci a justo sodales.</p>
                                                            <ul class="facilities-list fl-wrap">
                                                                <li><i class="fal fa-wifi"></i><span>Free WiFi</span></li>
                                                                <li><i class="fal fa-parking"></i><span>Parking</span></li>
                                                                <li><i class="fal fa-smoking-ban"></i><span>Non-smoking Rooms</span></li>
                                                                <li><i class="fal fa-utensils"></i><span> Restaurant</span></li>
                                                            </ul>
                                                            <div class="geodir-category-footer fl-wrap">
                                                                <div class="geodir-category-price">₹ /Night <span></span></div>
                                                                <div class="geodir-opt-list">
                                                                    <a href="#" class="single-map-item" data-newlatitude="40.72956781" data-newlongitude="-73.99726866"><i class="fal fa-map-marker-alt"></i><span class="geodir-opt-tooltip">On the map</span></a>
                                                                    <a href="#" class="geodir-js-favorite @if($place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif" data-id="{{$place->id}}"><i class="fal fa-heart"></i><span class="geodir-opt-tooltip">Add Wishlist</span></a>
                                                                    <a href="#" class="geodir-js-booking"><i class="fal fa-exchange"></i><span class="geodir-opt-tooltip">Find Directions</span></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <!-- listing-item end -->

                                            </div>
                                            <!-- listing-item-container end-->


