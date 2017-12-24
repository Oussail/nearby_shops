

# Nearby Shops

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

## Features
- As a User, I can sign up using my email & password
- As a User, I can sign in using my email & password
- As a User, I can display the list of shops sorted by distance
- As a User, I can like a shop, so it can be added to my preferred shops
  - Acceptance criteria: liked shops shouldn’t be displayed on the main page
- As a User, I can dislike a shop, so it won’t be displayed within “Nearby Shops” list during the next 2 hours
- As a User, I can display the list of preferred shops
- As a User, I can remove a shop from my preferred shops list

### Installing

- Install XAMPP with PHP7.0.
- Install Composer.
- Then excute those commands :
  - composer update
  - php artisan migrate


### Prerequisites

- You need to :
  - Create those tables in /phpMyadmin
```
CREATE TABLE IF NOT EXISTS t_shop(
  id int(11) primary key,
  shop_name VARCHAR(255) CHARSET utf8,
  shop_description VARCHAR(255) CHARSET utf8,
  shop_photo text,
  creation_date date,
  lat DECIMAL(10, 8) NOT NULL,
  lng DECIMAL(11, 8) NOT NULL
);
CREATE TABLE IF NOT EXISTS t_liked(
  liked datetime,
  user_id int(11) not null,
  shop_id int(11) not null,
  PRIMARY KEY (user_id, shop_id),
  FOREIGN KEY (shop_id) REFERENCES t_shop(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE IF NOT EXISTS t_disliked(
  unliked datetime,
  user_id int(11) not null,
  shop_id int(11) not null,
  PRIMARY KEY (user_id, shop_id),
  FOREIGN KEY (shop_id) REFERENCES t_shop(id),
  FOREIGN KEY (user_id) REFERENCES users(id)

);
```
  - Then insert some data like :
```
INSERT INTO t_shop(id,shop_name,shop_description,shop_photo,creation_date,lat,lng) 
VALUES
(1,'GALAXY SHOP',"Magasin d'appareil de fitness",'pic1.png',NOW(),33.9915249,-6.870811),
(2,'Animal Shop','magasin','pic2.png',NOW(),34.0201814,-6.8250954),
(3,'Crea Corner','magasin','pic3.png',NOW(),34.0140097,-6.8289578),
(4,'ABIOKIM Shop','magasin de store et de rideaux','pic4.png',NOW(),34.0041111,-6.8502867),
(5,'Eglo Concept Shop','Magasin de luminaires','pic5.png',NOW(),33.9884604,-6.8279707);
```


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Oussail Alaoui via [oussail.alaoui@gmail.com](mailto:oussail.alaoui@gmail.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
