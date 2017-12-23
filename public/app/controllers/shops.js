app.controller('ShopsController', function($scope, $http, API_URL) {
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
   
});