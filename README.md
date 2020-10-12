### Ejercicio para FOCAN formacion: Joel Glez Rod
# Initial Configuration Steps:
## Option 1: Vagrant (Linux, MacOS and Windows)
- Install vagrant: 
  - https://www.vagrantup.com/downloads
- Clone project
- Inside project run: (VagrantFile and provisioner.sh included)
  - vagrant up 
- Connect via SSH to your new VM: 
  - vagrant ssh
- Connect to mysql: user: root password: root 
  - mysql -u root -p
- Create and import DB in mysql: /vagrant/var/formacion.sql -> db_name: formacion
  - mysql> CREATE SCHEMA formacion;
  - /vagrant/var$ mysql -u root -p formacion < formacion.sql
- Create user for SCHEMA: becarios , password: becarios
  - mysql> CREATE USER 'becarios'@'localhost' IDENTIFIED BY 'becarios';
  - mysql> GRANT ALL PRIVILEGES ON formacion.* TO 'becarios'@'localhost' WITH GRANT OPTION;
  - mysql> FLUSH PRIVILEGES;
- Give all privileges to /vagrant/var/log/formacion.log (not secure but fast solution) -> This is for logger to work
  - sudo chmod 777 formacion.log
- In browser connect to: localhost:8080/
## Option 2: XAMPP (Windows)
- Clone project inside htdocs
- Modify your hosts file (C:/Windows/System32/drivers/etc/hosts)
  - add line: 127.0.0.1 formacion.test
- Add virtual host to XAMPP in X:\xampp\apache\conf\extra\httpd-vhosts.conf
  - add at the end of the file:
    <VirtualHost formacion.test:80>
    DocumentRoot "E:/xampp/htdocs/formacion/"
    </VirtualHost>
- LoadModule rewrite_module modules/mod_rewrite.so in X:\xampp\apache\conf\httpd.conf must be anabled and AllowOverride All must be setted
- Create and import DB in mysql: /vagrant/var/formacion.sql -> db_name: formacion, user: becarios, password: becarios
- Create user becarios in mysql for db 'formacion'
