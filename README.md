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

4.- DS18B20 http://www.bambusekd.cz/dev/raspberry-1-wire-temperature-ds18b20

# Copiar archivo sensorServer.py
1.- Copiar el archivo a la ubicación preferida y ejecutar
	cd /home/pi
	python3 sensorServer.py
	