

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](http://www.gnu.org/licenses/gpl-3.0)
![webtrees major version](https://img.shields.io/badge/webtrees-v2.1.x-green)
# HTML Block Advanced


An HTML Block using collapsible sections and enabling advanced styles and features. This module is an extension of the default webtrees HTML Block. It's templates are structured in multiple collapsible sections. The Starter template is a sampler of some features and styles suitable for a family history or biography.


Compatibility: webtrees 2.1.x <br>
Requires webtrees 2.1.20 for extended allowed classes and styles. 
There is a simple temporary patch available for previous versions of webtrees.

## Rationale
This module was designed to better display longform content such as an extensive family history narrative or biography that would otherwise produce one very long page.

## Installation

Install and enable the module:
* Download and unzip the release package.
* Place the ***webtrees-HTML-block-advanced*** folder inside ***modules_v4*** folder of your webtrees installation.
* Open the control panel, Modules | Home page | Blocks, make sure "enabled" is checked next to the html-block-advanced module, click "Save"

Note: Here you can also change the access level (recommended: Show to visitors) and order (recommended as the first tab to display)

## Upgrading
To upgrade an existing installation of the module, simply replace the html-block-advanced folder inside the modules_v4 folder with the new one.

## Loading starter content

Choose **Compact Sampler** from the Template dropdown. This will load the content of a demonstration template that can be edited, added to, and altered to suit your needs. This sampler template has collapsable sections and placeholder images and text. Add a **Title** and **Save**.<br>

***Caution!*** *this will overwrite any previously saved content.* See [Backup Section](#backup) below

The **Compact Vanilla** template contains only the collapsible sections with Lorem ipsum placeholder text for a clean start.<br> 

[More templates to come.](https://github.com/photon-flip/Templates-webtrees-HTML-Advanced)

<img src="docs/screenshot2.jpg" width="70%" ><br/>
View the result in the HTML Advanced Block you have added to your **My Page** or **Tree Home Page** from **My pages** menu - **Customise this page**.

<img src="docs/screenshot1.jpg" width="50%" >

## Customizing Content

<img src="docs/screenshot3.jpg" width="50%" >


### Editing content and adding sections


* You can use the WYSIWYG editor to add or remove content but this is not ideal for more complex content.
* Editing and customizing content is best done using the [Source] tab to access the underlying HTML code.
* To add new sections, use this example code.

 <span style="color:#c05050;font-size:1.2em"> **Important!** <br>**It is essential that the anchor href \# and div id use the same UNIQUE identifier - unique from all other sections.<br> 
 If more than one complete HTML Block Advanced is added to a page then all anchor href # and div ids will need to be changed so as to be different to the other block.** </span> 
 
```
<div class="compact__section"><a class="compact__section__title" href="#section-101">New Section</a>
    <div class="compact__section__content" id="section-101">
        <h3>New Section</h3>
        <p>Content here</p>
    </div>
</div>
```            
add new sections after the closing divs of a previous section

>               </div>
>           </div>

## Backup
It is good practice to make a backup copy of your edited content. It is easily possible to unintentionally overwrite your custom content by again selecting template from the dropdown. As long as you don't **Save**, selecting **Cancel** at this point will leave your content in place. The WYSIWYG editor also is rather unforgiving of custom code errors so while editing, regular backups are always a good idea.

To backup your content, select the [Source] tab in the editor and copy the source HTML code. This can be kept as a plain text file and pasted back into the editor source to restore.  


### Work on a full User Manual is ongoing
[User Manual wiki](https://github.com/photon-flip/webtrees-HTML-block-advanced/wiki)

