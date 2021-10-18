InfoCasas Demo - Task Manager Laravel Api Rest

- Clone Repo: git clone https://github.com/afonsogpedro/ic_backend.git
- Run:
	- cd ic_backend
	- composer install
	- copy .env.example .env
	- php artisan key:generate
- Add Database access data to .env file
- Run
	- php artisan migrate

To Test run "php artisan serve"

Test url's for Postman
- Register user    -> http://127.0.0.1:8000/api/register      -> POST
- Login               -> http://127.0.0.1:8000/api/login          -> POST
- User                -> http://127.0.0.1:8000/api/user           -> GET
- Tasks              -> http://127.0.0.1:8000/api/tasks          -> POST/GET
- Task               -> http://127.0.0.1:8000/api/tasks/{id}   -> GET
- Task Update    -> http://127.0.0.1:8000/api/tasks/{id}   -> PUT
- Task DELETE    -> http://127.0.0.1:8000/api/tasks/{id}   -> DELETE
- Logout            -> http://127.0.0.1:8000/api/user/logout  -> GET
