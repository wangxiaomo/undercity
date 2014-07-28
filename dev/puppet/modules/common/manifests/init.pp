class common {
    file { "/tmp/puppet":
        ensure  => "directory"
    }

    file { "/tmp/puppet/puppet-ping":
        content => "pong"
    }

    cron { "ntpdate":
        command =>  "/usr/sbin/ntpdate time.windows.com && /sbin/hwclock -w",
        minute  =>  "*/30"
    }
}
