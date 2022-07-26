
<table><tr>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/999962830474326036/unknown.png" width="90" /><br /></td>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/1001141818165039174/unknown.png" width="90" /><br /></td>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/1001142070204960868/unknown.png" width="90" /><br /></td>
</tr></table>

## symfo-ct-project
![Version](http://141.94.244.54:1010/version.svg)
![MIT license](http://141.94.244.54:1010/license-mit.svg)

Free and open source project developed during my intership at Cloud Temple. It was done with php 8, symfony 6, postgreSQL and docker.
Please feel free to clone it and play with it as you wish!

## Deploy project with docker 🐳

Install docker and docker-compose:
```bash
sudo apt install docker -y && sudo apt install docker -y
```

Add user to docker group (if not already added):
```bash
sudo usermod -aG docker $USER
```

Grant docker sock permission:
```bash
sudo chmod 666 /var/run/docker.sock
```

Create a symbolic link to /usr/bin:
```
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
```

Restart docker service:
```bash
sudo service docker restart
```

Clone the project:
```bash
git clone https://github.com/enzodjabali/symfo-ct-project
```

Create and start containers:
```bash
cd symfo-ct-project/ && docker-compose up
```

Get id of symfony container:
```bash
docker ps
```

<img width="550" src="https://cdn.discordapp.com/attachments/774340712585625603/1001254062991355934/container-under-id.jpg" />


Connect to container:
```bash
docker exec -it f8ff4b2bdac5 /bin/bash
```

Install dependencies with composer:
```bash
composer install

```
Create database:
```bash
symfony console d:d:c
```

Migrate database:
```bash
symfony console d:m:m
```

run symfony server (add `-d` to run it in background):
```bash
symfony server:start
```
Congrats! You can now access your symfony server at `localhost:9000` 🎉
