# CD Rent API

Cd Rent API is a service for rental and return any CD

## Docker Deployment

Read [this](https://github.com/zarszz/cd-rent-project/wiki/DEPLOYMENT-USING-DOCKER) wiki

## Authentication

*CD Rent API* uses JWT Authentication. First you can create new account. After you have created your account, you can login to get your token. After you acquired your token you can use this services.

## Media Types

Where applicable this API uses the JSON media type to represent resources states and affordances.

Requests with message-body are using plain JSON to set or update resources state.

## Error States

The common [HTTP Response Status Codes](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status) are used.

## CD Rent API Root [/]

This resources does not have any attribute.

## Group User

User related resources of CD Rent API

### Get all user [GET /api/user]

Retrieve all registered user in database

+ Request (application/json)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

+ Response (application/json)
  + Body
    + array of user (user)
  + Response 200 (OK)
  
    ```json
    [
        {
            "id": 3,
            "email": "lang.kenyatta@buckridge.com",
            "username": "cleve90",
            "first_name": "Roberto",
            "last_name": "McKenzie",
            "address": "8709 Jerrold Port South Merlin, WY 77805-9659",
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-19T03:51:00.000000Z"
        },
        {
            "id": 4,
            "email": "zconn@yahoo.com",
            "username": "cletus32",
            "first_name": "Felicita",
            "last_name": "Cruickshank",
            "address": "15614 Anna Village Myahstad, MD 20570-2698",
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-19T03:51:00.000000Z"
        }
    ]
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### Get user with id [GET /api/user<:id>]

Retrieve specific user by id

+ Request (application/json)
  + Parameter
    + id (integer)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

+ Response (application/json)
  + Body
    + email (string)
    + first_name (string)
    + last_name (string)
    + password (string)
    + username (string)
    + address (string)
    + updated_at (timestamp)
    + created_at (timestamp)
    + id (integer)
  + Response 200 (OK)
  
    ```json
        {
            "id": 4,
            "email": "zconn@yahoo.com",
            "username": "cletus32",
            "first_name": "Felicita",
            "last_name": "Cruickshank",
            "address": "15614 Anna Village Myahstad, MD 20570-2698",
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-19T03:51:00.000000Z"
        }
    ```

  + Reponse 404 (User not found)
  
    ```json
        "message": "user not found"
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### Update user with id [PUT /api/user<:id>]

Retrieve specific user by id

+ Request (application/json)
  + Parameter
    + id (integer)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

  + Body
    + email (string)
    + first_name (string)
    + last_name (string)
    + password (string)
    + username (string)
    + address (string)

  + Example
  
    ```json
        {
            "email": "zconn@yahoo.com",
            "username": "cletus32",
            "first_name": "Felicita",
            "last_name": "Cruickshank",
            "password": "password"
        }
    ```

+ Response (application/json)
  + Body
    + email (string)
    + first_name (string)
    + last_name (string)
    + password (string)
    + username (string)
    + address (string)
    + updated_at (timestamp)
    + created_at (timestamp)
    + id (integer)
  + Response 201 (CREATED)
  
    ```json
        {
            "id": 1,
            "email": "ucok@email.com",
            "username": "ucok",
            "first_name": "ucok",
            "last_name": "sulaiman",
            "address": "1742 Kimberly Grove Apt. 120\nBoydbury, CT 64306",
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-19T16:23:24.000000Z"
        }
    ```

  + Reponse 404 (User not found)
  
    ```json
        "message": "user not found"
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

## Group Compact Disc (CD)

Compact Disc (CD) related resources of CD Rent API

### Get all CDs [GET /api/compact-disc]

Retrieve all CD in database

+ Request (application/json)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

+ Response (application/json)
  + Body
    + array of cds (Compact Disc)
  + Response 200 (OK)
  
    ```json
    [
        {
            "id": 2,
            "title": "Pamela",
            "rate": 4.67,
            "category": "Osinski",
            "quantity": 38,
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-20T00:43:19.000000Z"
        },
        {
            "id": 3,
            "title": "Jefferey",
            "rate": 0.88,
            "category": "Toy",
            "quantity": 35,
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-19T03:51:00.000000Z"
        }
    ]
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### Get CD with id [GET /api/compact-disc/<:id>]

Retrieve specific CD by id

+ Request (application/json)
  + Parameter
    + id (integer)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

+ Response (application/json)
  + Body
    + id (integer)
    + title (string)
    + rate (float)
    + category (string)
    + quantity (integer)
    + updated_at (timestamp)
    + created_at (timestamp)
  + Response 200 (OK)
  
    ```json
        {
            "id": 2,
            "title": "Pamela",
            "rate": 4.67,
            "category": "Osinski",
            "quantity": 38,
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-20T00:43:19.000000Z"
        }
    ```

  + Reponse 404 (not found)
  
    ```json
        "message": "cd not found"
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### Update CD with id [PUT /api/compact-disc/<:id>]

Update specific CDs by id

+ Request (application/json)
  + Parameter
    + id (integer)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

  + Body
    + title (string)
    + rate (float)
    + category (string)
    + quantity (integer)

  + Example
  
    ```json
        {
            "title": "World war Z",
            "rate": "5.0",
            "category": "film",
            "quantity": "100"
        }
    ```

+ Response (application/json)
  + Body
    + title (string)
    + rate (float)
    + category (string)
    + quantity (integer)
    + address (string)
    + updated_at (timestamp)
    + created_at (timestamp)
    + id (integer)
  + Response 201 (CREATED)
  
    ```json
        {
        "id": 31,
        "title": "World war Z",
        "rate": 5.0,
        "category": "film",
        "quantity": 20,
        "created_at": "2020-03-19T11:43:38.000000Z",
        "updated_at": "2020-03-20T01:34:51.000000Z"
        }
    ```

  + Reponse 404 (not found)
  
    ```json
        "message": "not found"
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### Update stock CD with id [PATCH /api/compact-disc/<:id>]

Update CDs stock by id

+ Request (application/json)
  + Parameter
    + id (integer)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

  + Body
    + quantity (integer)

  + Example
  
    ```json
        {
            "quantity": 100
        }
    ```

+ Response (application/json)
  + Body
    + title (string)
    + rate (float)
    + category (string)
    + quantity (integer)
    + address (string)
    + updated_at (timestamp)
    + created_at (timestamp)
    + id (integer)
  + Response 201 (CREATED)
  
    ```json
        {
        "id": 31,
        "title": "World war Z",
        "rate": 5.0,
        "category": "film",
        "quantity": 100,
        "created_at": "2020-03-19T11:43:38.000000Z",
        "updated_at": "2020-03-20T01:34:51.000000Z"
        }
    ```

  + Reponse 404 (not found)
  
    ```json
        "message": "not found"
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### Create new CD [POST /api/compact-disc]

Create new cd and add it to database

+ Request (application/json)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

  + Body
    + title (string)
    + rate (float)
    + category (string)
    + quantity (integer)

  + Example
  
    ```json
        {
            "title": "Shingeky no Kyoojin",
            "rate": "5.0",
            "category": "anime",
            "quantity": 20
        }
    ```

+ Response (application/json)
  + Body
    + title (string)
    + rate (float)
    + category (string)
    + quantity (integer)
    + address (string)
    + updated_at (timestamp)
    + created_at (timestamp)
    + id (integer)
  + Response 201 (CREATED)
  
    ```json
        {
        "id": 31,
        "title": "Shingeky no Kyoojin",
        "rate": "5.0",
        "category": "anime",
        "quantity": 20,
        "created_at": "2020-03-19T11:43:38.000000Z",
        "updated_at": "2020-03-20T01:34:51.000000Z"
        }
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

## Group User Rent Compact Disc (CD)

Compact Disc (CD) related resources of CD Rent API

### Get all user rent [GET /api/user-rent]

Retrieve all relation between user and cd in database

+ Request (application/json)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

+ Response (application/json)
  + Body
    + array of user rent
  + Response 200 (OK)
  
    ```json
    [
      {
        "id": 1,
        "user_id": 26,
        "compact_disc_id": 5,
        "rent_date": "2020-03-19 03:51:00",
        "return_date": "2020-04-01 22:49:05",
        "created_at": "2020-03-19T03:51:00.000000Z",
        "updated_at": "2020-03-19T03:51:00.000000Z"
      },
      {
        "id": 2,
        "user_id": 1,
        "compact_disc_id": 11,
        "rent_date": "2020-03-19 03:51:00",
        "return_date": "2020-04-02 13:22:43",
        "created_at": "2020-03-19T03:51:00.000000Z",
        "updated_at": "2020-03-19T03:51:00.000000Z"
      }
    ]
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### Get all specific user rent [GET /api/user-rent-all]

Retrieve specific data in relation between user and cds

+ Request (application/json)
  + Parameter
    + id (integer)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

+ Response (application/json)
  + Body
    + user (User)
    + cd (CD)
  + Response 200 (OK)
  
    ```json
      [
        {
        "user": {
          "id": 1,
          "email": "onienow@corwin.info",
          "username": "ramiro89",
          "first_name": "Ines",
          "last_name": "Homenick",
          "address": "1742 Kimberly Grove Apt. 120\nBoydbury, CT 64306",
          "created_at": "2020-03-19T03:51:00.000000Z",
          "updated_at": "2020-03-19T03:51:00.000000Z"
        },
        "cd_data": {
          "id": 5,
          "title": "Rae",
          "rate": 0.91,
          "category": "Lebsack",
          "quantity": 9,
          "created_at": "2020-03-19T03:51:00.000000Z",
          "updated_at": "2020-03-19T03:51:00.000000Z"
        },
        "rent_date": "2020-03-19 03:51:00",
        "return_date": "2020-04-01 22:49:05"
      },
      {
        "user": {
          "id": 2,
          "email": "cole.selina@gmail.com",
          "username": "nicolas16",
          "first_name": "Deven",
          "last_name": "Wintheiser",
          "address": "9580 Trantow Mills\nSwaniawskiville, WI 09236",
          "created_at": "2020-03-19T03:51:00.000000Z",
          "updated_at": "2020-03-19T03:51:00.000000Z"
        },
        "cd_data": {
            "id": 11,
            "title": "Anahi",
            "rate": 1.9100000000000001,
            "category": "Bradtke",
            "quantity": 18,
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-19T03:51:00.000000Z"
        },
          "rent_date": "2020-03-19 03:51:00",
          "return_date": "2020-04-02 13:22:43"
        }
    ]
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### User rent CD [POST /api/rent]

User rental specifc CD identified by CD id.
Add data to transactional table between user and cd.

+ Request (application/json)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

  + Body
    + user_id (integer)
    + compat_disc_id (integer)

  + Example
  
    ```json
      {
        "user_id": 20,
        "compact_disc_id": 10
      }
    ```

+ Response (application/json)

  + Response 201 (CREATED)
  
    ```json
      {
        "status": "success",
        "message": {
          "user_id": 20,
          "compact_disc_id": 10,
          "rent_date": {
            "date": "2020-03-19 10:06:43.220650",
            "timezone_type": 3,
            "timezone": "UTC"
          },
          "updated_at": "2020-03-19T10:06:43.000000Z",
          "created_at": "2020-03-19T10:06:43.000000Z",
          "id": 32
        }
      }
    ```

  + Reponse 404 (not found)
  
    ```json
        "message": "user or cd not found"
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

### User return rented CD [POST /api/return]

User return rented CD.
Add 'return_date' TIMESTAMPS data to User and CDs transactional table if request successfully.

+ Request (application/json)
  + Headers
  
    ```header
    Authorization: bearer <YOUR_JWT_TOKEN>
    ```

  + Body
    + id [rental id] (integer)
    + user_id (integer)
    + compact_disc_id (integer)

  + Example
  
    ```json
        {
          "id": 32,
          "user_id": 20,
          "compact_disc_id": 10
        }
    ```

+ Response (application/json)
  + Body
    + status (string)
    + total rent day (integer)
    + cost (integer)
  + Response 201 (CREATED)
  
    ```json
        {
          "status": "success",
          "total rent day": 0,
          "cost": 2730,
          "dvd data": {
            "id": 10,
            "title": "Jarrett",
            "rate": 2.73,
            "category": "Hintz",
            "quantity": 42,
            "created_at": "2020-03-19T03:51:00.000000Z",
            "updated_at": "2020-03-19T11:12:45.000000Z"
          }
        }
    ```

  + Reponse 404 (not found)
  
    ```json
        "message": "not found"
    ```

  + Reponse 401 (Unauthorized)
  
    ```html
        Unauthorized
    ```

  + Reponse 400 (Error)
  
    ```json
       {
         "status": "failed"
       }
    ```

## Group Authentication and Authorization

Access and Control CD Rent API.

### Register [POST /api/register]

To create new account and stored in database for using this service.

+ Request (application/json)
  + Body
    + email (string, max 100)
    + first_name (string, max 100)
    + last_name (string, max 100)
    + password (string, max 100)
    + username (string, max 100)
    + address (string, max 100)
  + Example

    ```json
        {
            "email": "david@email.com",
            "username": "vid_dvd",
            "password": "password",
            "first_name": "David",
            "last_name": "Ricard",
            "address": "Ebah"
        }  
    ```

+ Response (application/json)
  + Response Code
    + 201 (created)
    + 400 (error)
  + Body
    + email (string)
    + first_name (string)
    + last_name (string)
    + password (string)
    + username (string)
    + address (string)
    + updated_at (timestamp)
    + created_at (timestamp)
    + id (integer)
  
  + Response 201 (created)
  
  ```json
        {
            "message": "created",
            "user": {
                "username": "vid_dvd",
                "email": "david@email.com",
                "first_name": "David",
                "last_name": "Ricard",
                "address": "Ebah",
                "updated_at": "2020-03-20T01:32:04.000000Z",
                "created_at": "2020-03-20T01:32:04.000000Z",
                "id": 1
            }
        }
  ```

  + Response 400 (error)
  
  ```json
    {
        "message": "registration error"
    }
  ```

### Login [POST /api/login]

To login with created account and get JWT key

+ Request
  + Body (application/json)
    + email (string)
    + password (string)
  + Example

  ```json
    {
        "email": "david@email.com",
        "password": "password"
    }
  ```

+ Response
  + Response code
    + 200 (OK)
    + 400 (error)
  + Body
    + data (array)
    + token (string)
    + toke_type (string)
    + expires_in (integer) (minutes)
  + Response 200 (OK)
  
  ```json
    {
        "message": "success",
        "data": {
            "token": "YOUR_TOKEN",
            "token_type": "bearer",
            "expires_in": 86400
        }
    }
  ```

  + Response 400 (Email or password wrong)
  
  ```json
    {
        "message": "email or password wrong"
    }
  ```
