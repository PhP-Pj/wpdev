# wordpressdev site

## URL

[My WordPress site running on Apache2](http://my.wpdev.com:88/wp-admin/)

## Admin

user devwpadmin
devwpadmin!

## Tuto summary and explanation

* [General info about WordPress](./wp-content/themes/wptp/README.md)
* [Tuto about wptp theme - plugin - wigets ](./wp-content/themes/wptp/WPTP.md)


## debugging

[Debugging in WordPress](https://wordpress.org/support/article/debugging-in-wordpress/)

### Suggestion from stackexchange

```
if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}

write_log('THIS IS THE START OF MY CUSTOM DEBUG');
//i can log data like objects
write_log($whatever_you_want_to_log);
```
