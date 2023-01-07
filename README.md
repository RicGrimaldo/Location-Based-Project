# Location Based Project

Location Based Project repository for augmented  reality, developed with the AR.js library.

## Documentation

- [AR.js - Augmented Reality on the Web](https://ar-js-org.github.io/AR.js-Docs/)
- [Location Based](https://ar-js-org.github.io/AR.js-Docs/location-based/)
- [AR.js & A-Frame Gestures](https://github.com/fcor/arjs-gestures)
- [Location Based AR Tutorial - AR.js v2.0.x](https://github.com/nicolocarpignoli/location-based-ar-tutorial)
- [A-Frame documentation](https://aframe.io/)
- [AR.js examples](https://github.com/AR-js-org/AR.js)

## Instructions to install the project

1. Clone the project.
2. Create the `locationsdb` database.
3. Go to the folder application using `cd` command on your cmd or terminal.
4. Run the following commands:
    - `composer install`
    - `copy .env.example .env`
    - `php artisan key:generate`
    - `php artisan storage:link`
    - `php artisan migrate`
    - `php artisan serve`