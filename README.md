# Инструкция для проверки

1. Клонировать репозиторий

```git clone git@github.com:sparco114/t_technovizor.git```

2. Перейти в директорию проекта

```cd t_technovizor```

3. Выполнить сборку и запуск контейнеров

```docker-compose up -d --build```

4. Проверить, что все три контейнера запущены (php, nginx и mariadb)

```docker ps```

5. Открыть в браузере страницу

```http://localhost```

