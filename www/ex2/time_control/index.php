<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оценка производительности");
?>

    <h2>[ex2-88]</h2>

    products/index.php - 18.02%
    </br>
    ------
    </br>
    Работа компонента по умолчанию: bitrix:news.detail: 0.0356 с; Запросов: 5 (0.0021 с); кеш: 7 КБ
    </br>
    ------
    </br>

    Работа компонента только с необходимым кешированием:bitrix: news.detail: 0.0386 с; Запросов: 6 (0.0026 с); кеш: 4 КБ
    </br>
    ------
    </br>
    Разница в объемах кеша: 3 КБ

    <h2>[ex2-10]</h2>

    /products/index.php - 28.10%
    </br>
    ------
    </br>
    Работа компонента с самой долгой загрузкой: bitrix:catalog: 0.1205 с
    </br>
    ------
    <h2>[ex2-11]</h2>

    /products/index.php - 28.10%
    </br>
    ------
    </br>
    Работа компонента с самой долгой загрузкой: bitrix:catalog: 0.1205 с
    </br>
    ------

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>