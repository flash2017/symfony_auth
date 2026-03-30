#Auth
Пример базовой JWT- авторизации:
- на Symfony version="7.4.*"` 
- бандела lexik/jwt-authentication-bundle 
- monolog логирование

Обработка исключений реализована через подписки на события:
- **kernel.exception**

Логирование запросов реализовано через подписки на события
- kernel.request
- kernel.response
В логах проверяется X-Request-ID и если отсутсвует, то генерируется уникальный идентификатор запроса.   

Что добавить:
- дополнительные данные пользователя
- Csrf
- Docker 

## Authentication

| Request | Method | Description |
|---|---|---|
| `registration` | POST | Register a new user account using email and password. |
| `login` | POST | Authenticate a user with email and password to receive a JWT access token. |
| `me` | GET | Retrieve the currently authenticated user's profile. Requires a valid Bearer token. |
| `refresh` | POST | Obtain a new access token using a refresh token, without requiring re-authentication. |

All secured endpoints use **Bearer token (JWT)** authentication. Use the `login` request first to obtain a token, then pass it in the `Authorization` header for subsequent requests.
