
<table><tr>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/999962830474326036/unknown.png" width="90" /><br /></td>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/1001141818165039174/unknown.png" width="90" /><br /></td>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/1001142070204960868/unknown.png" width="90" /><br /></td>
<td align="center"><img src="https://cdn.discordapp.com/attachments/997412174311981136/1003973686367367168/nginx-smalllogo.png" width="90" /><br /></td>
</tr></table>

## symfo-ct-project
![Version](http://141.94.244.54:1010/version.svg)
![MIT license](http://141.94.244.54:1010/license-mit.svg)

Free and open source project developed during my intership at Cloud Temple. It was done with php 8, symfony 6, postgreSQL and docker.
Please, feel free to clone it and play with it as you wish!

<br>

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
<br>
<b>Create a copy of the `.env` file then name it `.env.local` and fill it out</b>
<br>

Connect to php container:
```bash
docker exec -it php sh
```

Install dependencies with composer:
```sh
composer install
```

Update var/ directory:
```sh
chmod -R 777 var/
```

Create database:
```sh
bin/console d:d:c
```

Migrate database:
```sh
bin/console d:m:m
```

Congrats! You can now access your app server at `localhost:8080` 🎉

<br>

## Useful tips 📎

Grant permissions to www-data (might solve cache errors from liip/imagine-bundle):
```bash
sudo chown -R $USER:www-data symfo-ct-project/ && sudo chmod -R g+r+x+w symfo-ct-project/
```

Load fixtures with faker (in php container):
```sh
bin/console d:f:l
```
<br>

## Access and manage database 🐘

Access PostgreSQL container:
```bash
docker exec -it symfo-ct-project_database_1 sh
```

Connect to database:
```sh
psql -U symfony -d app
```

List users:
```sql
SELECT * FROM public.user;
```

Set user verified:
```sql
UPDATE public.user SET verified = true WHERE id = 1;
```

Set user super admin:
```sql
UPDATE public.user SET roles = '["ROLE_SUPER_ADMIN"]' WHERE id = 1;
```
<br>
<i>Thanks and enjoy 👋</i>
