const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/Setting/handleDepartment.js', 'public/js/Setting')
   .js('resources/js/Setting/handleUsers.js', 'public/js/Setting')
   .postCss('resources/css/app.css', 'public/css')
   .version(); // luôn bật versioning
