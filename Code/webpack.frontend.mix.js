const mix = require('laravel-mix');

// Admin
mix.webpackConfig({
    output: {
        path:__dirname+'/public/dist/frontend',
    }

});

mix.sass('public/sass/app.scss','css');
mix.sass('public/sass/contact.scss','css');
mix.sass('public/sass/rtl.scss','css');
mix.sass('public/sass/notification.scss','css');
// ----------------------------------------------------------------------------------------------------
//Booking
mix.sass('public/module/order/scss/checkout.scss','module/order/css');
mix.sass('public/module/user/scss/user.scss','module/user/css');
mix.sass('public/module/user/scss/profile.scss','module/user/css');
mix.sass('public/module/news/scss/news.scss','module/news/css');
mix.sass('public/module/media/scss/browser.scss','module/media/css');
mix.sass('public/module/location/scss/location.scss','module/location/css');
mix.sass('public/module/social/scss/social.scss','module/social/css');
mix.sass('public/module/gig/scss/gig.scss','module/gig/css');
