
<table><tr>
<td align="center"><a href="https://www.enzuzo.com/"><img src="https://graphile.org/images/sponsors/enzuzo.png" width="90" height="90" alt="Enzuzo" /><br />Enzuzo</a> *</td>
<td align="center"><a href="https://politicsrewired.com/"><img src="https://graphile.org/images/sponsors/politics-rewired.png" width="90" height="90" alt="Politics Rewired" /><br />Politics Rewired</a></td>
<td align="center"><a href="https://iasql.com/"><img src="https://graphile.org/images/sponsors/IaSQL.png" width="90" height="90" alt="IaSQL" /><br />IaSQL</a></td>
</tr></table>



Install docker and docker-compose:
```bash
sudo apt install docker -y && sudo apt install docker -y
```

Add user to docker group (if not already added):
```bash
sudo usermod -aG docker $USER
```

sudo chmod 666 /var/run/docker.sock


Create a symbolic link to /usr/bin:
```
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
```

Restart docker service
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
