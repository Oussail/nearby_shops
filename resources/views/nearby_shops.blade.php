@extends('layouts.app')

@section('content')
<div class="col-md-12">
<div class="row">
  <img class="loading" src="css/loading-dots.gif" alt="">
  <div id="app-shops" class="container" ng-app="NearbyShops" hidden>
	 <div class="col-md-12" ng-controller="ShopsController">
		<div class="col-md-3" ng-repeat="shop in shops">
			<div id="shop-@verbatim{{ shop.id }}@endverbatim" class="card" style="width: 20rem;" >
  				<img class="card-img-top img-responsive" src="{{ asset('Images/pic@verbatim{{ shop.id }}@endverbatim.png') }}" alt="">
  				<div class="card-body">
  				@verbatim
  				{{ url }}
    				<h4 class="card-title">{{ shop.shop_name }}</h4>
    				<p class="card-text">{{ shop.shop_description }}</p>
    				<a href="#" class="btn btn-primary" ng-click="likeShop(shop.id)">Like</a> <a href="#" class="btn btn-danger" ng-click="dislikeShop(shop.id)">Dislike</a>
    			@endverbatim
  				</div>
			</div>
			<br>
		</div>
	 </div>
  </div>
</div>
</div>
<style type="text/css">
  .loading {
    display: block;
    margin: auto;
  }
</style>

@endsection
