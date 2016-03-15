var path          = require('path');
var environments  = require('gulp-environments');

module.exports = {
    src     : 'src/Client/Bundle/WebsiteBundle/Resources/assets/default',
    dest    : 'src/Client/Bundle/WebsiteBundle/Resources/public/default',
    dev     : environments.development,
    prod    : environments.production
};
