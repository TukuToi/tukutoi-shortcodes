# tukutoi-shortcodes
 Indispensable ShortCodes for ClassicPress (and WordPress without Blocks) Websites.

TukuToi ShortCodes provides you with a bunch of ShortCodes useful for dynamic webdevelopment.
Basically the entire WordPress API has been "ShortCode-ified" in this Plugin. You can display any kind of site, post, user, taxonomy or else Information dynamically.

The ShortCodes can be nested inside each other, where it makes sense, the ShortCodes can be used both as enclosed or not encosing ShortCodes and take ShortCodes as attributes as well.

One of the most powerful features in the Plugin is a "conditional" ShortCode allowing you to write "if/else/elseif" statements directly in your favourite WordPress Text Editor.

You can easily register your own ShortCodes as well, and even pass new Attributes to existing ShortCodes. 

Documentation lives direclty inside the ShortCodes, as with a special parameter passed to any of the ShortCodes, each attribute will be shown on the site with its expected content type.

This is like a Page builder, just that you will use HTML to build your layouts and then make them dynamic with ShortCodes.

ShortCodes available so far:

Blog Info [tkt_scs_bloginfo]
Post Info [tkt_scs_postinfo]
User Info [tkt_scs_userinfo]
Term Info [tkt_scs_terminfo]
Post Terms Info [tkt_scs_post_termsinfo]
User Meta Data [tkt_scs_usermeta key="first_name"]
Term Meta Data [tkt_scs_termmeta item="3" key="my-key"]
Post Meta Data [tkt_scs_postmeta key="my-key"]

All ShortCodes take exactly the same arguments as the functions.