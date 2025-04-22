<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

```
Data cource: https://jsonplaceholder.typicode.com/users
```

### Tasks.
 - Implement a function to retrieve user data from JSONPlaceholder 
(https://jsonplaceholder.typicode.com/users) via REST API;
- Synchronize the retrieved data in a MySQL database. Please consider that:
- - If a user already exists in the database, their data should be updated, not duplicated;
- - If a user exists in the database but is absent in the API response, their data should be soft-deleted;
- Create a page that will display a list of all users stored in the database;
- Implement a function called on a schedule (Laravel Scheduler) to update user data from JSONPlaceholder regularly;
- To build the project, you can use Docker Compose (optional);


### Commands as superuser to initialize the application

The system must first have the necessary components installed,
such as composer, git, docker. PHP version >8.1.
Sail has been removed completely from composer applications and dependencies.

```
> cd /path_to_projects
> git clone https://github.com/Igor-ad/laravel_jsonplaceholder-typicode_api.git
> cd /path_to_projects/laravel_jsonplaceholder-typicode_api
> cp ./.env.example ./.env
```

It is necessary to fill in the parameters of the environment file ./.env with the following values:
DB_PASSWORD.
Update libraries and modules. Create and run a containers.

```
> composer update
> chmod 777 -R ./storage/logs
> docker-compose build 
> docker-compose up 
```

The Laravel home page must be accessible from a local address
http://localhost/.
If the directories that Laravel should write to are not writable on behalf of the owner,
connecting to the home page may cause a number of access errors.
The following commands will open "public" entry access to the appropriate directories.
```
> chmod 755 -R ./public
> chmod 755 ./.env
> chmod 777 -R ./storage/framework/sessions
> chmod 777 ./storage/framework/views
> chmod 777 ./storage/framework/cache/data
> php artisan key:generate
> php artisan migrate
> php artisan db:seed
```

If the migration command returns a database connection error,
then you should replace in the environment file ./.env
the value of the DB_HOST parameter to the IP address of the MySQL container.
(Database connection error may appear during the testing phase)
The IP address of the MySQL container can be obtained by running the command:
```
> docker inspect `docker ps|grep mysql|cut -d' ' -f1`|grep '"IPAddress": "1'|cut -d'"' -f4
```

and repeat the migration command

```
> php artisan migrate
> php artisan db:seed
```

database/seeders/UserSeeder.php generates one test user - “admin” for implementing GET requests via api_key authentication.


If testing is carried out on another machine on the local network,
connection to the Redis container may fail.
In this case, you should replace ./.env in the environment file
the value of the REDIS_HOST parameter to the IP address of the redis container.
The IP address of the redis container can be obtained by running the command:

```
> docker inspect `docker ps|grep redis|cut -d' ' -f1`|grep '"IPAddress": "1'|cut -d'"' -f4
```

Update data into DB from remote source:

```
> php artisan app:content
```

### Routes

```
update data:
GET|HEAD   api/run .................................. run › Api\ContentController

get index User collection:
GET|HEAD   api/index ...................... user.index › Api\UserController@index

get index Addresses collection:
GET|HEAD   api/addresses ............ address.index › Api\AddressController@index

get index Companies collection:
GET|HEAD   api/companies ............ company.index › Api\CompanyController@index

get index Geo collection:
GET|HEAD   api/geo .......................... geo.index › Api\GeoController@index
```

#### Example GET queries

```
http://localhost/api/run?api_key=*12345678*
http://localhost/api/index?api_key=*12345678*
http://localhost/api/addresses?api_key=*12345678*
http://localhost/api/companies?api_key=*12345678*
http://localhost/api/geo?api_key=*12345678*
```

#### Example remote API Response

```
[
  {
    "id": 1,
    "name": "Leanne Graham",
    "username": "Bret",
    "email": "Sincere@april.biz",
    "address": {
      "street": "Kulas Light",
      "suite": "Apt. 556",
      "city": "Gwenborough",
      "zipcode": "92998-3874",
      "geo": {
        "lat": "-37.3159",
        "lng": "81.1496"
      }
    },
    "phone": "1-770-736-8031 x56442",
    "website": "hildegard.org",
    "company": {
      "name": "Romaguera-Crona",
      "catchPhrase": "Multi-layered client-server neural-net",
      "bs": "harness real-time e-markets"
    }
  },
  {
    "id": 2,
    "name": "Ervin Howell",
    "username": "Antonette",
    "email": "Shanna@melissa.tv",
    "address": {
      "street": "Victor Plains",
      "suite": "Suite 879",
      "city": "Wisokyburgh",
      "zipcode": "90566-7771",
      "geo": {
        "lat": "-43.9509",
        "lng": "-34.4618"
      }
    },
    "phone": "010-692-6593 x09125",
    "website": "anastasia.net",
    "company": {
      "name": "Deckow-Crist",
      "catchPhrase": "Proactive didactic contingency",
      "bs": "synergize scalable supply-chains"
    }
  },
  {
    "id": 3,
    "name": "Clementine Bauch",
    "username": "Samantha",
    "email": "Nathan@yesenia.net",
    "address": {
      "street": "Douglas Extension",
      "suite": "Suite 847",
      "city": "McKenziehaven",
      "zipcode": "59590-4157",
      "geo": {
        "lat": "-68.6102",
        "lng": "-47.0653"
      }
    },
    "phone": "1-463-123-4447",
    "website": "ramiro.info",
    "company": {
      "name": "Romaguera-Jacobson",
      "catchPhrase": "Face to face bifurcated interface",
      "bs": "e-enable strategic applications"
    }
  },
  {
    "id": 4,
    "name": "Patricia Lebsack",
    "username": "Karianne",
    "email": "Julianne.OConner@kory.org",
    "address": {
      "street": "Hoeger Mall",
      "suite": "Apt. 692",
      "city": "South Elvis",
      "zipcode": "53919-4257",
      "geo": {
        "lat": "29.4572",
        "lng": "-164.2990"
      }
    },
    "phone": "493-170-9623 x156",
    "website": "kale.biz",
    "company": {
      "name": "Robel-Corkery",
      "catchPhrase": "Multi-tiered zero tolerance productivity",
      "bs": "transition cutting-edge web services"
    }
  },
  {
    "id": 5,
    "name": "Chelsey Dietrich",
    "username": "Kamren",
    "email": "Lucio_Hettinger@annie.ca",
    "address": {
      "street": "Skiles Walks",
      "suite": "Suite 351",
      "city": "Roscoeview",
      "zipcode": "33263",
      "geo": {
        "lat": "-31.8129",
        "lng": "62.5342"
      }
    },
    "phone": "(254)954-1289",
    "website": "demarco.info",
    "company": {
      "name": "Keebler LLC",
      "catchPhrase": "User-centric fault-tolerant solution",
      "bs": "revolutionize end-to-end systems"
    }
  },
  {
    "id": 6,
    "name": "Mrs. Dennis Schulist",
    "username": "Leopoldo_Corkery",
    "email": "Karley_Dach@jasper.info",
    "address": {
      "street": "Norberto Crossing",
      "suite": "Apt. 950",
      "city": "South Christy",
      "zipcode": "23505-1337",
      "geo": {
        "lat": "-71.4197",
        "lng": "71.7478"
      }
    },
    "phone": "1-477-935-8478 x6430",
    "website": "ola.org",
    "company": {
      "name": "Considine-Lockman",
      "catchPhrase": "Synchronised bottom-line interface",
      "bs": "e-enable innovative applications"
    }
  },
  {
    "id": 7,
    "name": "Kurtis Weissnat",
    "username": "Elwyn.Skiles",
    "email": "Telly.Hoeger@billy.biz",
    "address": {
      "street": "Rex Trail",
      "suite": "Suite 280",
      "city": "Howemouth",
      "zipcode": "58804-1099",
      "geo": {
        "lat": "24.8918",
        "lng": "21.8984"
      }
    },
    "phone": "210.067.6132",
    "website": "elvis.io",
    "company": {
      "name": "Johns Group",
      "catchPhrase": "Configurable multimedia task-force",
      "bs": "generate enterprise e-tailers"
    }
  },
  {
    "id": 8,
    "name": "Nicholas Runolfsdottir V",
    "username": "Maxime_Nienow",
    "email": "Sherwood@rosamond.me",
    "address": {
      "street": "Ellsworth Summit",
      "suite": "Suite 729",
      "city": "Aliyaview",
      "zipcode": "45169",
      "geo": {
        "lat": "-14.3990",
        "lng": "-120.7677"
      }
    },
    "phone": "586.493.6943 x140",
    "website": "jacynthe.com",
    "company": {
      "name": "Abernathy Group",
      "catchPhrase": "Implemented secondary concept",
      "bs": "e-enable extensible e-tailers"
    }
  },
  {
    "id": 9,
    "name": "Glenna Reichert",
    "username": "Delphine",
    "email": "Chaim_McDermott@dana.io",
    "address": {
      "street": "Dayna Park",
      "suite": "Suite 449",
      "city": "Bartholomebury",
      "zipcode": "76495-3109",
      "geo": {
        "lat": "24.6463",
        "lng": "-168.8889"
      }
    },
    "phone": "(775)976-6794 x41206",
    "website": "conrad.com",
    "company": {
      "name": "Yost and Sons",
      "catchPhrase": "Switchable contextually-based project",
      "bs": "aggregate real-time technologies"
    }
  },
  {
    "id": 10,
    "name": "Clementina DuBuque",
    "username": "Moriah.Stanton",
    "email": "Rey.Padberg@karina.biz",
    "address": {
      "street": "Kattie Turnpike",
      "suite": "Suite 198",
      "city": "Lebsackbury",
      "zipcode": "31428-2261",
      "geo": {
        "lat": "-38.2386",
        "lng": "57.2232"
      }
    },
    "phone": "024-648-3804",
    "website": "ambrose.net",
    "company": {
      "name": "Hoeger LLC",
      "catchPhrase": "Centralized empowering task-force",
      "bs": "target end-to-end models"
    }
  }
]
```
