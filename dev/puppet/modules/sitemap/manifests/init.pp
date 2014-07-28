class sitemap {
    cron { sitemap_sxjjw_index:
        command => "cd /data/www/html/sitemap && /usr/local/php/bin/php sxjjw_index.php",
        hour    => 3,
        minute  => 15,
        ensure  => "present"
    }

    cron { sitemap_sxjjw_subsite:
        command => "cd /data/www/html/sitemap && /usr/local/php/bin/php sxjjw_subsite.php",
        hour    => 3,
        minute  => 15,
        ensure  => "present"
    }

    cron { sitemap_gsjjw:
        command => "cd /data/www/html/sitemap && /usr/local/php/bin/php gsjjw.php",
        hour    => 3,
        minute  => 15,
        ensure  => "present"
    }
}

class sitemap::disable {
    cron { sitemap_sxjjw_index: ensure => "absent" }
    cron { sitemap_sxjjw_subsite: ensure => "absent" }
    cron { sitemap_gsjjw: ensure => "absent" }
}
