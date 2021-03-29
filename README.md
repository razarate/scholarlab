# scholarlab
Scholar lab

# Instalar cherripy
1.- https://docs.cherrypy.org/en/latest/install.html
	pip3 install cherrypy

# Instalar librerías para sensores utilizados
1.- Instalar librerías CircuitPython https://learn.adafruit.com/circuitpython-on-raspberrypi-linux/installing-circuitpython-on-raspberry-pi
	pip3 install RPI.GPIO
	pip3 install adafruit-blinka

2.- DHT11 Adafruit https://learn.adafruit.com/dht-humidity-sensing-on-raspberry-pi-with-gdocs-logging/python-setup
3.- BMP280 - Adafruit
	Activar I2C https://learn.adafruit.com/adafruits-raspberry-pi-lesson-4-gpio-setup/configuring-i2c
	sudo apt-get install -y python-smbus
	sudo apt-get install -y i2c-tools
	
	sudo raspi-config
	Enable! I2C
	Testing sudo i2cdetect -y 1

	sudo pip3 install adafruit-circuitpython-bmp280

4.- BME280 - Adafruit
	Activar I2C https://learn.adafruit.com/adafruits-raspberry-pi-lesson-4-gpio-setup/configuring-i2c
	sudo apt-get install -y python-smbus
	sudo apt-get install -y i2c-tools
	
	sudo raspi-config
	Enable! I2C
	Testing sudo i2cdetect -y 1
	
	Python Installation of BME280 Library
	sudo pip3 install adafruit-circuitpython-bme280

5.- DS18B20 http://www.bambusekd.cz/dev/raspberry-1-wire-temperature-ds18b20

# Copiar archivo sensorServer.py
1.- Copiar el archivo a la ubicación preferida y ejecutar
	cd /home/pi
	python3 sensorServer.py
	Agregar al cron iniciar el servidor web
		crontab -e
		@reboot python /home/pi/sensorServer.py &


# Instalar joomla https://projects.raspberrypi.org/en/projects/lamp-web-server-with-wordpress
1.- Instalar Nginx https://roaldjoosen.nl/blog/lemp-server-raspberry-pi.html
	sudo apt install nginx
	sudo nano /etc/nginx/sites-enabled/default
		index index.php index.html index.htm
		location ~ \.php$ {
		    include snippets/fastcgi-php.conf;
		    fastcgi_pass unix:/run/php/php7.3-fpm.sock;
		}
	Agregar aquí una locación para que funcione la redirección de joomla https://serverfault.com/questions/862219/joomla-at-nginx-remove-slashes-doesnt-work-properly
		location / {
	        try_files $uri $uri/ @joomlaurls;
	    }
	    location @joomlaurls {
	        rewrite ^/(.+)/$ /$1 permanent;
	        try_files $uri $uri/ /index.php?$args;
	        error_page 404 = /index.php;
	    }
	Administrar Nginx
	# start webserver
		sudo /etc/init.d/nginx start
		# Iniciar al booteo
			sudo update-rc.d -f nginx defaults;
	# stop webserver
		sudo /etc/init.d/nginx stop
	# restart webserver
		sudo /etc/init.d/nginx restart

2.- Instalar php
	sudo apt install php-fpm

3.- Instalar Maria DB
	sudo apt-get install mariadb-server php-mysql -y
	sudo mysql_secure_installation
		sudo mysql -uroot -p
		# database aanmaken
			CREATE DATABASE database_name;
		# gebruiker aanmaken
			CREATE USER 'user_name'@'localhost' IDENTIFIED BY 'password';
		# gebruiker toevoegen aan database
			GRANT ALL PRIVILEGES ON database_name.* TO 'user_name'@'localhost';
		# ververs rechten
			FLUSH PRIVILEGES;
			quit
4.- Subir archivos joomla
	Dar permiso a pi para modificar archivos https://dev.to/katieadamsdev/raspberry-pi-index-html-permissions-4d35
		sudo chown -R pi /var/www/html
		Instalar módulo php xml
			sudo apt-get install php-xml
		Subir archivos y descomprimir
		Visitar http://localhost para instalar
		#Para JoomShaper es necesario instalar otros módulos de php
			CURl
				sudo apt-get install curl
				sudo apt-get install php-curl
			MB_string
				sudo apt-get install php-mbstring
	Cron para sensores (*/15 * * * *  curl "http://192.168.0.16/index.php?option=com_scholarlab&view=cron&format=raw")
	Regresar los permisos para la carpeta pública
		sudo chown -R www-data /var/www/html

5.- Instalar phpmyadmin https://pimylifeup.com/raspberry-pi-phpmyadmin/
	sudo apt install phpmyadmin

	Para Nginx
	sudo ln -s /usr/share/phpmyadmin /var/www/html
# start webserver
sudo /etc/init.d/nginx start
# stop webserver
sudo /etc/init.d/nginx stop
# restart webserver
sudo /etc/init.d/nginx restart

6.- Instalar Matomo https://matomo.org/docs/installation
INSTALAR ANALYTICS