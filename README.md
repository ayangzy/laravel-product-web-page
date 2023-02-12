
## Overview 

This project Create a webpage with a form that has the following text input fields: Product name, Quantity in stock, Price per item and the submitted data of the form is save in XML file
Underneath of the form, the web page display all of the data which has been submitted in rows ordered by date time submitted, the order of the data columns is: Product name, Quantity in stock, Price per item, Datetime submitted, Total value number.
The "Total value number" is calculated as (Quantity in stock * Price per item).
The last row show a sum total of all of the Total Value numbers and finally update is made on each of the line
## Installation & Usage
<hr/>

You can simply clone  ``laravel-product-web-page`` like below on your git bash

```bash
git clone https://github.com/ayangzy/laravel-product-web-page
```
After cloning the project, please run this command on the project directory
```
composer install
```
Run 

```
php artisan key:generate
```
To generate the application key

After doing this. Just go ahead and serve you application.
```
php artisan serve
```

## Credits
- [Ayange Felix](https://github.com/ayangzy)


