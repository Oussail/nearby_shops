app.controller('ShopsController', function($scope, $http, API_URL,$location) {
    //get user ip
    if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position){
      //retrieve the closest Shops listing by coordination 
        $http({
      	method: 'GET',
      	url: API_URL + 'get_shops',
      	params:{lat: position.coords.latitude,lng: position.coords.longitude}
   			}).then(function(response) {
        		$scope.shops = response.data;
   			});
      
    });
    }else {
      alert("Geolocation is not supported in your browser");
    };
  //Like and Dislike call button
  $scope.OpinionShop = function(id,user_opinion,$window) {
        if (user_opinion==1) {
            $http({
                method: 'GET',
                url: API_URL + 'user_opinion',
                params:{shop_id: id, opinion: user_opinion}
            }).then(function(response) {
            window.location.reload();
        });
        } else if(user_opinion==0) {
            $http({
                method: 'GET',
                url: API_URL + 'user_opinion',
                params:{shop_id: id, opinion: 'dislike'}
            }).then(function(response) {
              window.location.reload();
        });
        }
}

});