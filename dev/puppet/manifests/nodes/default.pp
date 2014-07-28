node default {
    include common
    include sitemap::disable

    package { ["samba", "samba-client", "samba-swat"]:
        ensure  => installed,
    }
    
    service { "smb":
        ensure    => running,
        enable    => true,
        hasstatus => true,
        hasrestart=> true,
        require   => Package["samba"]
    }
}
