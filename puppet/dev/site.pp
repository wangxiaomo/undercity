node default {
    file {
        "/tmp/puppet/puppet-ping": content=>'pong';
    }
}

import "nodes/localhost.pp"
import "cron/*.pp"
