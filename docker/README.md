### SSH
- ip: XXX
- user: XXX
- password: XXX

### Host installation
- Create Droplet using `docker based image`.
- Preparing host machine

    ```bash
    $ apt-get -y upgrade && apt-get -y update
    $ sed -i 's/Port 22/Port 25252/' /etc/ssh/sshd_config
    $ apt-get -y install ufw
    $ ufw allow 25252
    $ ufw allow 80
    $ ufw allow 443
    $ ufw allow 4330
    $ ufw default deny incoming
    $ ufw enable
    
    $ shutdown -r now
    
    docker swarm init --advertise-addr=XXXX
    
    $ nano portainer-agent-stack.yml
    # copy/past `portainer-agent-stack.yml` content
    
    $ docker stack deploy --compose-file=portainer-agent-stack.yml portainer
    ```

### Portainer login console

- http://XXX:4330
- user: admin
- pass: XXX

### First Deployment

```bash
$ nano docker-compose.yml

# copy/past `docker-compose.yml` content
# enable `DATA_SETUP=1` to create database in first time.

$ docker stack deploy --compose-file=docker-compose.yml takeoff
```

### Notes
Don't forgot access to RabbitMQ to bind `amq.direct` exchange to your queues `worker,socket`
