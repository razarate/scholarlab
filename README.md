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

4.- Subir archivos joomla
	Dar permiso a pi para modificar archivos https://dev.to/katieadamsdev/raspberry-pi-index-html-permissions-4d35
		sudo chown -R pi /var/www/html
		Instalar módulo php xml
			sudo apt-get install php-xml
		Subir archivos y descomprimir
		Visitar http://localhost para instalar
		#Para JoomShaper es necesario instalar otros módulos de php
	Cron para sensores (*/15 * * * *  wget http://192.168.0.13/index.php/escuela-cron)

5.- Instalar phpmyadmin https://pimylifeup.com/raspberry-pi-phpmyadmin/
	sudo apt install phpmyadmin
# start webserver
sudo /etc/init.d/nginx start
# stop webserver
sudo /etc/init.d/nginx stop
# restart webserver
sudo /etc/init.d/nginx restart