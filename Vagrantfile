# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.network :forwarded_port, guest: 80, host: 8080
  config.vm.host_name = "learnosity-demo.dev"

  config.vm.provision "shell", inline: <<-SHELL
     apt-get update
     apt-get install -y vim curl git-core
     apt-get install -y php7.0 apache2 libapache2-mod-php7.0 php7.0-curl php7.0-gd php7.0-mcrypt php7.0-cli

     # Make us the default site
     sed -i 's^DocumentRoot.*^DocumentRoot /vagrant/www^' /etc/apache2/sites-available/000-default.conf
     cat << EOF > /etc/apache2/conf-available/vagrant-www.conf
<Directory /vagrant/www>
	Options Indexes FollowSymLinks
	AllowOverride None
	Require all granted
</Directory>
EOF
     ln -sf ../conf-available/vagrant-www.conf /etc/apache2/conf-enabled/
     service apache2 restart
  SHELL
end
