# PageBuilder

This module allows you to create a page builder of products or contents of similar themes 
(Best sellers, Best rated by women, .. for example). The page builder will then be displayed as  list
of those products or contents. 

## Compatibility 
* To use this module on Thelia 2.3.x, use the tag 1.1.2

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is PageBuilder.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/page builder-module:~1.1.2
```

## Usage

Once activated, a new button called "PageBuilder" will appear in the tool menu on the left sidebar of the admin panel.
Clicking on it will redirect you to the list of all the page builders you've created so far.

Once on the page with all your page builders you may :

- Create a new page builder by clicking on the + button at the top right of the page.
- Toggle the visibility of your page builder (whether people will see it or not) by clicking on the "Online" button in
front of the page builder you wish to make visible or invisible.
- Edit an already created page builder by clicking on its name or on the cog button then on the pencil button in front
of the page builder you wish to edit.
- Delete a page builder by clicking on the cog button then on the trash button in front of the page builder you wish to delete.

You may then display your page builder on your website by calling the page builder_list loop.

## Hook

This module has a single hook in the back office, adding the PageBuilder button to the tools menu of the sidebar on
the left, redirecting to the list of page builder.

## Loop

[page builder_list]

This loop returns a list of page builders. You can use it to display the page builders you've created in your website.

### Input arguments

|Variable       |Description |
|---            |--- |
|**id**         | A string containing the IDs of all the page builders you wish to display. To get the ID of the current rewritten URL, use : $app->request->get('page builder_id') in your template|
|**title**      | The title of the page builder you wish to display |
|**visible**    | Whether your page builder will be visible or not. Default : true |
|**position**   | The position of the page builder you wish to display |
|**exclude**    | A string containing the IDs of all the page builders you wish not to display |

### Output arguments

|Variable                   |Description |
|---                        |--- |
|**PAGE_BUILDER_ID**           | The ID of the current PageBuilder |
|**PAGE_BUILDER_TITLE**        | The title of the current PageBuilder |
|**PAGE_BUILDER_DESCRIPTION**  | The description of the current PageBuilder |
|**PAGE_BUILDER_CHAPO**        | The chapo of the current PageBuilder |
|**PAGE_BUILDER_POSTSCRIPTUM** | The postscriptum of the current PageBuilder |
|**PAGE_BUILDER_VISIBLE**      | Whether the current page builder is visible or not |
|**PAGE_BUILDER_POSITION**     | The position of the current page builder |
|**PAGE_BUILDER_URL**          | The URL of the current page builder |

### Exemple
````
    {loop name="page builder_list" type="page builder_list" visible=true id='1,4'}
        This page builder id           : {$PAGE_BUILDER_ID}
        This page builder title        : {$PAGE_BUILDER_TITLE}
        This page builder status       : {$PAGE_BUILDER_VISIBLE}
        This page builder description  : {$PAGE_BUILDER_DESCRIPTION}
        This page builder chapo        : {$PAGE_BUILDER_CHAPO}
        This page builder url          : {$PAGE_BUILDER_URL}
        This page builder postscriptum : {$PAGE_BUILDER_POSTSCRIPTUM}
        This page builder position     : {$PAGE_BUILDER_POSITION}
    {/loop}
````

[page builder_image]

This loop returns the images related to a page builder. 

### Input arguments

Input Arguments are extended by Thelia\Core\Templates\Loop\Image

### Output arguments

Output Arguments are extended by Thelia\Core\Templates\Loop\Image


### Exemple
````
    {loop type="page builder_image" name="page builder_image" source="page builder" source_id=$PAGE_BUILDER_ID limit="1" visible="true"}
    {/loop}
````

