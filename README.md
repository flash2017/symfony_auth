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

Что добавить:
- дополнительные данные пользователя
- Csrf
- Docker 
