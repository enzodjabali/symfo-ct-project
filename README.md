
<table><tr>
<td align="center"><a href="https://surge.io/"><img src="https://graphile.org/images/sponsors/surge.png" width="90" height="90" alt="Surge" /><br />Surge</a> *</td>
<td align="center"><a href="https://storyscript.com/?utm_source=postgraphile"><img src="https://graphile.org/images/sponsors/storyscript.png" width="90" height="90" alt="Story.ai" /><br />Story.ai</a> *</td>
<td align="center"><a href="http://chads.website"><img src="https://graphile.org/images/sponsors/chadf.png" width="90" height="90" alt="Chad Furman" /><br />Chad Furman</a> *</td>
<td align="center"><a href="https://www.the-guild.dev/"><img src="https://graphile.org/images/sponsors/theguild.png" width="90" height="90" alt="The Guild" /><br />The Guild</a> *</td>
</tr><tr>
<td align="center"><a href="https://qwick.com/"><img src="https://graphile.org/images/sponsors/qwick.png" width="90" height="90" alt="Qwick" /><br />Qwick</a> *</td>
<td align="center"><a href="https://www.fanatics.com/"><img src="https://graphile.org/images/sponsors/fanatics.png" width="90" height="90" alt="Fanatics" /><br />Fanatics</a> *</td>
<td align="center"><a href="https://stellate.co/"><img src="https://graphile.org/images/sponsors/Stellate.png" width="90" height="90" alt="Stellate" /><br />Stellate</a> *</td>
<td align="center"><a href="https://dovetailapp.com/"><img src="https://graphile.org/images/sponsors/dovetail.png" width="90" height="90" alt="Dovetail" /><br />Dovetail</a> *</td>
</tr><tr>
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
