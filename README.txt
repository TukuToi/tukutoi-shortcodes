=== TukuToi ShortCodes ===
Contributors: bedas
Donate link: https://www.tukutoi.com/
Tags: shortcodes, classicpress
Requires at least: 1.0.0
Tested up to: 4.9.99
Stable tag: 1.22.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description == 

TukuToi ShortCodes provides you with a bunch of ShortCodes useful for dynamic webdevelopment.
Basically a bunch of WordPress methods and objects have been "ShortCode-ified" in this Plugin. 
You can display any kind of site, post, post term, user, taxonomy, usermeta, postmeta and termmeta information.

By nesting shortcodes inside each other you can have powerful dynamic output, such as this example"
`[tkt_scs_post_termsinfo item="[tkt_scs_postinfo item="" show="ID" filter="raw" sanitize="text_field"]" taxonomy="category" show="term_id" delimiter=", " sanitize="text_field"]`
Above would output all the Term IDs of the Post, where you inserted the shortcode.
It gets the current Post ID with the Shortcode nested inside the Post Term Information ID attribute.

This is not possible in WordPress anymore since 4.2.3 https://wptavern.com/plugin-developers-demand-a-better-security-release-process-after-wordpress-4-2-3-breaks-thousands-of-websites but thanks to the crafty developers at Toolset, I was able to build a ShortCode Processor using their code as reference which allows just that.

The Plugin comes with a Backend GUI to insert the ShortCodes (and choose/insert options), look for the `TukuToi ShortCodes` Button on post or page editors.

One of the most powerful features in the Plugin is a "conditional" ShortCode allowing you to write "if/else" statements directly in your favourite WordPress Text Editor like so:
```
[tkt_scs_conditional left="The past is WP" right="The Future is CP" operator="eqv" else="The Compared values where not true!"]
  The Compared values where true!
[/tkt_scs_conditional]
```
Above would return `The Compared values where not true!` as the values are not equal.

And no, it does not use `eval()`. It uses a custom set of expressions, and does not parse user input to PHP directly.

Duh, did I mention you can do math with the plugin too?
All valid Mathematical operations are possible. Even the weirdest Modulo.

== Current ShortCodes: ==

- archivelinks — TukuToi `[archivelinks]` ShortCode.

- attachmentimage — TukuToi `[attachmentimage]` ShortCode.

- bloginfo — TukuToi `[bloginfo]` ShortCode.

- conditional — TukuToi `[conditional]` ShortCode.

- editlinks — TukuToi `[editlinks]` ShortCode.

- math — TukuToi `[math]` ShortCode.

- post_termsinfo — TukuToi `[post_termsinfo]` ShortCode.

- postinfo — TukuToi `[postinfo]` ShortCode.

- postmeta — TukuToi `[postmeta]` ShortCode.

- round — TukuToi `[round]` ShortCode.

- terminfo — TukuToi `[terminfo]` ShortCode.

- termmeta — TukuToi `[termmeta]` ShortCode.

- userinfo — TukuToi `[userinfo]` ShortCode.

- usermeta — TukuToi `[usermeta]` ShortCode.

All ShortCodes take pretty much the same arguments as the corresponding WP/CP functions and the display attributes generally follow the WP/CP naming of object props or array keys.

As said, all ShortCodes can be inserted in the Post Editors using a Dymamic GUI that lets you compose the ShortCode attributes, with custom values or where appropriate with existing "object properties".

Have a look at just *some* of the possible Output...

```
[tkt_scs_bloginfo show="language" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="version" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="html_type" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="charset" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="admin_email" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="template_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="stylesheet_directory" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="stylesheet_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="pingback_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="comments_rss2_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="comments_atom_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="atom_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="rss2_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="rss_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="rdf_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="description" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="wpurl" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="name" filter="raw" sanitize="text_field"]</br>

[tkt_scs_postinfo item="" show="post_name" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="ID" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_author" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_date" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_date_gmt" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_content" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_title" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_excerpt" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_status" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="comment_status" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="ping_status" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_password" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_name" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="to_ping" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="pinged" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_modified" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_modified_gmt" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_content_filtered" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_parent" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="guid" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="menu_order" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_type" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_mime_type" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="comment_count" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="filter" filter="raw" sanitize="text_field"]</br>


[tkt_scs_userinfo item="" field="id" value="" show="ID" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_login" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_pass" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_nicename" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_email" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_url" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_registered" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_activation_key" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_status" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="display_name" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="caps" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="cap_key" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="roles" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="allcaps" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="filter" sanitize="text_field"]</br>

[tkt_scs_terminfo item="1" show="term_id" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="name" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="slug" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="term_group" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="term_taxonomy_id" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="taxonomy" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="description" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="parent" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="count" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="filter" filter="raw" sanitize="text_field"]</br>

[tkt_scs_post_termsinfo item="" taxonomy="category" show="term_id" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="name" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="slug" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="term_group" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="term_taxonomy_id" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="taxonomy" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="description" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="parent" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="count" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="filter" delimiter=", " sanitize="text_field"]</br>

[tkt_scs_usermeta item="" key="first_name" single="true" delimiter="" sanitize="text_field"]</br>
[tkt_scs_usermeta item="" key="last_name" single="true" delimiter="" sanitize="text_field"]

[tkt_scs_termmeta item="3" key="mikes"  delimiter="" sanitize="text_field"]

[tkt_scs_postmeta item="" key="testing_the_field" single="true" delimiter="" filter="raw" sanitize="text_field"]

[tkt_scs_conditional left="[tkt_scs_postinfo item="" show="ID" filter="raw" sanitize="text_field"]" right="1" operator="eq" else="no true!"][tkt_scs_postinfo item="" show="post_name" filter="raw" sanitize="text_field"][/tkt_scs_conditional]

[tkt_scs_math operand_one="2" operand_two="3" operator="+" sanitize="intval"]
```

You have your own ShortCode?

Duh, just add it to the GUI.
It requires 2 simple filters and a classic "add_shortcode" call.
You can then use our API to add a full fledged GUI for your shortcode.
That is simpler than you  think - with 4 lines of code, you already would have 4 settings in the GUI, 
possibly select options populated dynamically with Post, User or Term data, and more.
You can of course also pass your complete custom options and settings.

```
/**
 * Register your new shortcode.
 * 
 * You MUST pass all array key=>values
 * You MUST NOT return an empty array or reset the array
 */
add_filter( 'tkt_scs_register_shortcode', 'register_my_new_shortcode' );
function register_my_new_shortcode( $shortcodes ){

  $shortcodes['newcode'] = array(
    'label' => 'My New Thing',
    'type'  => 'informational',
  );

  return $shortcodes;

}
```
```
/**
 * Add your new shortcode's GUI.
 * 
 * You MUST check for your shortcode.
 * You MUST pass a valid PHP file path in which you provide your Settings Form.
 * You MAY or MAY NOT use our API to create the Settings Form, but you MUST use minimally:
 * - a Form wrapping your ShortCode settings inputs `<form class="tkt-shortcode-form">`
 * - a fieldset wrapping each of your inputs `<fieldset>`
 * - an input ID, NAME matching your ShortCode name
 * - you SHOULD add a label with corresponding for attribute `<label for="">LABEL</label>`
 * - you MAY add Descriptions inside a `<small class="tkt-shortcode-option-explanation"><em>` wrapper
 * You MUST escape every variable used in your custom labels, attributes, etc
 * You SHOULD add sanitization, single or double quotes Settings to your GUI (Just the API for that, it is one call)
 */
add_filter( 'tkt_scs_newcode_shortcode_form_gui', 'add_newcode_shortcode_gui', 10, 2 );
function add_newcode_shortcode_gui( $file, $shortcode ){
  
  if( $shortcode === 'newcode' ){
    $file = get_template_directory() . '/test.php';
  }

  return $file;

}
```
```
/**
 * Add your new shortcode.
 * 
 * You MUST use the tkt_scs_ prefix for the shortcode tag.
 * You MAY use any callback name you want.
 */
add_shortcode( 'tkt_scs_newcode', 'mewnewcode' );
function mewnewcode(){
  $out = 'new shortcode';
  return $out;
}
```

== Add your own shortcodes to supported inner ShortCodes ==

When you want to use your own ShortCodes inside HTML or ShortCode attributes, 
but do not register them with the TukuToi ShortCodes GUI, you can use this filter:
```
add_filter( 'tkt_scs_custom_inner_shortcodes', 'my_shortcodes', 10, 1 );
function my_shortcodes( $shortcodes ) {

  $shortcodes[] = 'my_shortcode_tag';

  return $shortcodes;
  
}
```

== Changelog ==

= 1.22.4 =
* [Fixed] Combobox produced an unwanted value as ShortCode attributes when inserting

= 1.22.3 =
* [Fixed] Load jQuery UI with custo scope for compatibility
* [Fixed] Loop and Search ShortCodes now insert with closing tags
* [Added] jQuery Autosuggest instead of select for easier searching of options.
* [Changed] Several improvements to GUI

= 1.20.1 =
* [Added] Support for Custom ShortCodes inside Attributes
* [Fixed] Conditional was broken if only TukuToi ShortCode wihout Search and Filters was active

= 1.19.0 =
* [Added] Support Conditionals in Loops, and ShortCodes in attributes in loops, while retaining query capability
* [Changed] ShortCode declarations now support a `inner` key, declaring whether ShortCodes is allowed inside attributes

= 1.18.1 =
* [Fixed] Shenanigans with Nested and Attribute ShortCodeds in Loops

= 1.18.0 =
* [Added] Common Code files and logic
* [Changed] Filter name to preprocess the shortcodes

= 1.17.1 =
* [Fixed] Crazy typo can break everything without even a notice. Inner ShortCodes did not expand anymore.. because of a missing "n" in a variable :)

= 1.17.0 =
* [Changed] All Select Options of the GUI now accept a array as callback array($object,'method')

= 1.16.0 =
* [Fixed] Post Terms Info was defaulting to Term ID
* [Added] Filter to add custom ShortCode Types: `tkt_scs_register_shortcode_type`
* [Changed] Moved plugin to init from after_setup_theme to leave more room for hooks

= 1.15.1 =
* [Fixed] Error in the GUI when calling Select Inputs

= 1.15.0 =
* [Added] Documentation Standards Complying Comments for most of the code
* [Added] Proper Filter documentation
* [Removed] Unused Files and Folders

= 1.14.5 =
* [Changed] Completed comments in code, refactored some aspects
* [Fixed] WPCS Complaints
* [Added] i18n

= 1.13.4 =
* [Fixed] jQuery Selects where not loading
* [Fixed] Ugly focus rings are now consistent on all browsers

= 1.13.2 =
* [Fixed] Typos in strings
* [Fixed] Alignment of Checkbox Options in GUI
* [Changed] Use Floats when Conditionals are numeric
* [Changed] Improved GUI with sections of ShortCode Groups
* [Changed] Improved Conditional ShortCode handling of Floats versus Integers/Strings
* [Changed] THIS MIGHT BREAK MY OWN THINGS. Moved entire plugin to after_setup_theme, because otherwise hooks from Themes wont work.
* [Added] Support for Epsilon in Conditionals when using numbers
* [Added] Support for Post Type Archive link in Post Info ShortCode
* [Added] Support for Term Archive link in Term Info ShortCode
* [Added] Support for Taxonomy Type on Term Info ShortCode GUI
* [Added] Support for Post and Term (inclusive post term) Type Edit and Archive links
* [Added] Support for single or double quotes setting in GUI
* [Added] Support for Conditional Operators Selectable in GUI
* [Added] Support for Attachment (Image) ShortCode
* [Added] Support for Rounding Floats ShortCode
* [Added] 2 new filters that let you add your own Custom ShortCode to the TukuToi Plugin GUI and use its API

= 1.7.1 =
* [Added] Math ShortCode. Yep. People asked for this for 7 years in Toolset. Can't be that hard.
* [Fixed] Console error when inserting in Text mode
* [Fixed] Conditional ShortCode is now autoclosing on insertion

= 1.6.0 =
* [Fixed] All Shortcode are now producing healthy and useful output
* [Fixed] Added warnings when inserting Post Content Shortcode in a current post
* [Fixed] Full handling of User Object now possible
* [Fixed] All ShortCodes in GUI now have explanation where applicable 
* [Fixed] In Text mode now shortcodes append to content instead of replacing content
* [Fixed] Now text_direction (even if retardedly handled by WP/CP) uses is_rtl properly
* [Changed] Added more meaningful debug logs
* [Changed] Added custom jQuery UI Theme
 

= 1.5.0 =
* [Added] Full class management for all GUI elements
* [Fixed] Issue where shortcodes inserted with memorized attributes
* [Changed] full class management for validation,sanitization,error handling, declarations
* [Changed] Version number and readme
* [Changed] Also did a full test round and refactor/code style polish.

= 1.4.0 =
* [Added] Added ShortCodeGUI

= 1.3.0 =
* [Added] Added Conditional ShortCode

= 1.2.0 =
* [Added] Added Inner and Nested ShortCodes

= 1.1.0 =
* [Added] Added Post, User and Term plus respective meta ShortCodes

= 1.0.0 =
* Initial Commit

== Bug repots ==

Open a ticket in this Git Repo.