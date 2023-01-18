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

Make sure your files are formatted correctly:
`npm run format` 

Make sure your files pass ESLint with the provided config:
`npm run lint:js` 

Build files for production:
`npm run build`

Build styles: 
`sass assets/css/source/style.scss assets/css/style.css --style=compressed`

### Autoloader

To generate autoload files, run 
`composer dump-autoload` 

### Translations

Generate and use .pot/.po/.mo files as usual. Make sure to include translations in Twig templates.

Transform po files into additional JSON for use with Javascript.
See [the guide in dev docs](https://developer.wordpress.org/block-editor/how-to-guides/internationalization/)

Example: 
`wp i18n make-json planet4-gpch-plugin-blocks-de_CH.po --no-purge`

Then rename the files to use the handle instead of the auto generated md5 string in the filename.
