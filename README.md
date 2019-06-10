## Deploy manual

### Local setup

Install deployer (v5.1.3)
```bash
curl -LO https://deployer.org/releases/5.1.3/deployer.phar
mv deployer.phar /usr/local/bin/dep
chmod +x /usr/local/bin/dep
```
Additional packages
```bash
composer global require symfony/yaml
```

Install Ansible on Ubuntu ([other OS](https://docs.ansible.com/ansible/latest/installation_guide/intro_installation.html#intro-installation-guide))
```bash
sudo apt-get update
sudo apt-get install software-properties-common
sudo apt-add-repository --yes --update ppa:ansible/ansible
sudo apt-get install ansible
```

Then check version is installed:
```bash
ansible --version
```

### Setup server for deploy
```bash
sh setup_dev.sh
```
If you have error:
- *WARNING: REMOTE HOST IDENTIFICATION HAS CHANGED!*
```bash
ssh-keygen -R "server ip"
```
- *WARNING: UNPROTECTED PRIVATE KEY FILE!*
```bash
sudo chmod 600 .ssh/dev && sudo chmod 600 .ssh/dev.pub
```

### Deployer

Release
```bash
dep release dev
```

Update code from git
```bash
dep update dev
```

