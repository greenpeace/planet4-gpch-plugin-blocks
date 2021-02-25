# planet4-gpch-plugin-blocks
Content Blocks, specific to the GPCH installation of Planet4.

## Development

### Install

`npm install --save-dev`

### Build
Build files for production:
`npm run build`

Live building for development
`npm run start`

Styles
`sass assets/css/source/style.scss assets/css/style.css`

### Autoloader
To generate autoload files, run 
`composer dump-autoload` 

## Blocks ##

### Accordion

...


### Action Divider

...


### Form Counter Text

...


### Form Progress Bar

![alt text](documentation/img/block_form_progress_bar.png "Form Progress Bar Block")

Displays a progress bar based on form entries. Can be used for petitions or other forms built with Gravity Forms.

Capability to also connect to an international counter (JSON value expected).


### Jobs

...


### Magazine Articles

...


### Newsletter

...


### Spacer

...


### Taskforce

...


## Technical overview ##

Uses:
* Composer Autoload
* SCSS
* [Timber Wordpress Plugin](https://wordpress.org/plugins/timber-library/)
