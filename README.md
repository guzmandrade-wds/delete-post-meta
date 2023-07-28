# delete-post-meta

## Delete Post Meta

Delete Post Meta based on meta key. Wrapper and admin panel for [delete_metadata](https://developer.wordpress.org/reference/functions/delete_metadata/).

> _WARNING!_
> Use this plugin with caution. It will delete all post meta based on a meta key.

## Filter Object Type

Add the following to your `functions.php` or equivalent send a different object type.

```php

add_filter('dpm_meta_key_object_type', function ($object_type){
    // Accepts 'post', 'comment', 'term', 'user', or any other object type with an associated meta table.
    return 'user';
});

```
