### Фильтры товаров

- Абстрактный класс, который описывает поведение
  классов которые будут наследовать его - [AbstractFilter](src/Domain/Catalog/Filters/AbstractFilter.php)
- Классы, которые содержат все данные о фильтрах: тип, имя, логика применения фильтра(билдер), ссылку на view и
  т.д. - [app/Filters](app/Filters). Их же используем для отрисовке на фронте при помощи __toString(). Нэймспейсы с
  именами храним в базе данных(по идее какие-то еще данные можно хранить в базе и давать редактировать заказчику, надо
  думать как и что именно туда пихать), а регаем в провайдере, при
  помощи [FilterManager](src/Domain/Catalog/Filters/FilterManager.php)
- Хелпер [src/Support/helpers.php](src/Support/helpers.php#L22)

### Order processing pipeline

- Интерфейс с единственным методом - [OrderProcessPipe](src/Domain/Order/Contracts/OrderProcessPipe.php)
- Процессы, его реализующие - [src/Domain/Order/Processes](src/Domain/Order/Processes)
- Использвуем [CheckoutController](app/Http/Controllers/CheckoutController.php#L68)
