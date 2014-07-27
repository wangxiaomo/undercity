cron { ntpdate:
    command =>  '/usr/sbin/ntpdate time.windows.com && /sbin/hwclock -w',
    minute  =>  '*/30',
}
