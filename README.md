# Task List

Project ini adalah bagian back-end API dari hasil test 'Junior FullStack Web Developer' saya.

aplikasi ini dibuat dengan laravel

# Dokumentasi

## Instalasi

Dengan composer

```bash
composer install
```
## Setup
### Database Connection
edit file `.env.example` menjadi `.env`
lalu edit:

```dotenv
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```
dengan setup database anda
contoh dengan setup default postgresql
```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

### Migrate dan seed
```bash
php artisan migrate
php artisan db:seed --class=CategorySeeder
```

## Run
```bash
php artisan serve
```

## Testing
idealnya untuk melakukan testing menggunakan database khusus untuk operasi testing
buat file `.env.testing` (bisa dengan mengcopy `.env` atau `.env.example`) kemudian edit setup database
contoh dengan menggunakan postgres
```dotenv
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=testing
DB_USERNAME=postgres
DB_PASSWORD=postgres
```
lalu run

```bash
php artisan test
```

## API Endpoint

<ul>
<li><h3>GETCategory</h3>

>Method: GET

```cURL
http://127.0.0.1:8000/api/categories/
```

Response
>status: 200
```json
[
    {
        "id": int,
        "name": 'string'
    }
]
```
contoh response
```json
[
    {
        "id": 1,
        "name": "Todo"
    },
]
```

</li>
<li><h3>POSTTaskandUser</h3>

>Method: POST

```cURL
http://127.0.0.1:8000/api/task/
```

Request Body JSON

> Content-Type menggunakan `application/json`

```json
{
    "name" : string,
    "email" : string-email,
    "username" : string,
    "task" : [
        {
            "category_id" : int,
            "description" : string
        },
    ]
}
```

contoh

```json
{
    "name": "jane doe",
    "email": "janed@jd.com",
    "username": "janedoe",
    "task": [
        {
            "category_id": 1,
            "description": "janedoeishere1"
        }
    ]
}
```

Response 
>status: 200

```json
{
    "newuser": {
        "id": int,
        "name" : string,
        "email" : string-email,
        "username" : string,
        "updated_at": string,
        "created_at": string,
    },
    "newtask": [
        {
            "id": int,
            "category_id": int,
            "description": string,
            "created_by": int,
            "user_id": int,
            "updated_at": string,
            "created_at": string,
        },
    ]
}
```
contoh response
```json
{
    "newuser": {
        "id": 24,
        "name": "jane does",
        "email": "janeds@jd.com",
        "username": "janedoes",
        "updated_at": "2024-09-10T08:01:28.000000Z",
        "created_at": "2024-09-10T08:01:28.000000Z",
    },
    "newtask": [
        {
            "id": 24,
            "category_id": 1,
            "description": "janedoeishere1",
            "created_by": 24,
            "user_id": 24,
            "updated_at": "2024-09-10T08:01:28.000000Z",
            "created_at": "2024-09-10T08:01:28.000000Z",
        },
    ]
}
```
</li>
<li><h3>DELETETask</h3>

>Method: DELETE
```cURL
http://127.0.0.1:8000/api/task/
```

Request Body JSON

> Content-Type menggunakan `application/json`
```json
{
    "name" : string,
    "email" : string,
    "username" : string
}
```

contoh

```json
{
    "name" : "john doe",
    "email" : "jd@jd.com",
    "username" : "jd"
}
```
response
>status: 200
```json
[
    {
        "id": int,
        "user_id": int,
        "category_id": int,
        "description": string,
        "created_by": int,
        "updated_by": int,
        "deleted_by": int,
        "created_at": string,
        "updated_at": string,
        "deleted_at": string
    }
]
```
contoh response
```json
[
    {
        "id": 13,
        "user_id": 20,
        "category_id": 5,
        "description": "johndoeishere5",
        "created_at": "2024-09-09T17:42:15.000000Z",
        "updated_at": "2024-09-10T07:03:57.000000Z",
        "created_by": 20,
        "updated_by": null,
        "deleted_by": 15,
        "deleted_at": "2024-09-10T07:03:57.000000Z"
    }
]
```
