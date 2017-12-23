app.controller('PreferredShopController', function($scope, $http, API_URL,$location) {
  $http({
        method: 'GET',
        url: API_URL + 'preferred_shop'
        }).then(function(response) {
            $scope.f_shops = response.data;
        });
  //remove Shop
  $scope.RemoveShop = function(id) {
            $http({
                method: 'GET',
                url: API_URL + 'remove_shop',
                params:{shop_id: id}
            }).then(function(response) {
            window.location.reload();
        });
        };
});