# planet4-gpch-plugin-blocks
Content Blocks, specific to the GPCH installation of Planet4.

## Install
Install dependencies:

`npm install --save-dev`

`composer install --ignore-platform-reqs`

## Coding Standards

Any new code added is required to implement [Wordpress coding standards](https://www.privacytools.io)

### Javascript: Use JSHint

Set JSHint to use .jshintrc provided in this repository.

**Example for PHPStorm:**

* Settings -> Languages & Frameworks -> Javascript -> Code Quality Tools -> JSHint
* ☑ Enable
* ☑ Use config files
* Location: ☑ Default

### Build

Make sure your JS files are formatted correctly:
`npm run format:js:src` 

Make sure your files pass ESLint with the provided config:
`npm run lint:js:src` 

Build files for production:
`npm run build`

Live building for development:
`npm run start`

Build styles: 
`sass assets/css/source/style.scss assets/css/style.css --style=compressed`

### Autoloader
To generate autoload files, run 
`composer dump-autoload` 
