node 'localhost' {
    file {
        "/tmp/puppet/puppet-localhost": content=>'pong';
    }
}
