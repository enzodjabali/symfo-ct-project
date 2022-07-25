
<table><tr>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/999962830474326036/unknown.png" width="90" /><br /></td>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/1001141818165039174/unknown.png" width="90" /><br /></td>
<td align="center"><img src="https://cdn.discordapp.com/attachments/774340712585625603/1001142070204960868/unknown.png" width="90" /><br /></td>
</tr></table>

# symfo-ct-project

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
