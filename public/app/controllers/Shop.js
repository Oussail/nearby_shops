app.controller('ShopsController', function($scope, $http, API_URL,$location) {
    //get user ip
    if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position){
      //retrieve the closest Shops by coordination 
        $http({
      	method: 'GET',
      	url: API_URL + 'get_shops',
      	params:{lat: position.coords.latitude,lng: position.coords.longitude}
   			}).then(function(response) {
        		$scope.shops = response.data;
            setTimeout(function() {
              $(".loading").fadeOut(100);
              $("#app-shops").fadeIn(120);
            },500);
   			});
      
    });
    }else {
      alert("Geolocation is not supported in your browser");
    };
  //Like button
  $scope.likeShop = function(id) {
    $http({
      method: 'GET',
      url: API_URL + 'like_shop',
      params:{shop_id: id}
        }).then(function(response) {
          $("#shop-"+id+"").parent().hide(500);
        });
  };
  //Dislike call
  $scope.dislikeShop = function(id) {
    $http({
      method: 'GET',
      url: API_URL + 'dislike_shop',
      params:{shop_id: id}
        }).then(function(response) {
          $("#shop-"+id+"").parent().hide(500);
        });
  };

});