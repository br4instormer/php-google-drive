# Скрипт для загрузки резервных копий аудио файлов с сайта на Google диск

Реализация [задачи](https://www.fl.ru/projects/5157698/skript-dlya-zagruzki-rezervnyih-kopiy-audio-faylov-s-sayta-na-google-disk.html) с fl.ru. Задание принято заказчиком.

Код опубликован в демонстрационных целях.

> Нужна консультация, как дополнить действующий механизм загрузки аудио файлов на сайт (через форму загрузки) одновременной загрузкой их резервных копий на Google диск. Что добавить в действующий скрипт, что еще сделать, чтобы это стало работать.

## Цель

1. Реализовать механизм загрузки файлов в облако Google Drive с помощью сервисного аккаунта.
2. Интегрировать механизм в предметную область.

## Стэк

* PHP v8
* пакет [google/apiclient](https://github.com/googleapis/google-api-php-client)

## Эксплуатация

### Установка

1. За пределами публичного каталога разместить:

    ```bash
    > tree
    .
    ├── composer.json
    ├── composer.lock
    └── src
        └── GoogleDrive.php
    ```

2. Выполнить команду `composer install`
3. Загрузить [файл реквизитов](https://gist.github.com/br4instormer/23745134ea82e9ce0a96b173bd3f2e6e) сервисного аккаунта `credentials.json`
4. Интегрировать код из скрипта `html/main.php` в клиентский код
