import board
import digitalio
import busio
import time
import adafruit_bmp280

import random
import string
import json

from gpiozero import CPUTemperature

import cherrypy


# Create library object using our Bus I2C port
i2c = busio.I2C(board.SCL, board.SDA)

# Sensor
def bmp280Sensor():
	return adafruit_bmp280.Adafruit_BMP280_I2C(i2c)

def cpuTemp():
	return CPUTemperature()


class SensorData(object):

	@cherrypy.expose
	def index(self):
		return "Hello world!"

	@cherrypy.expose
	def allData(self):
		bmp280 = bmp280Sensor()

		# change this to match the location's pressure (hPa) at sea level
		bmp280.seaLevelhPa = 1014
		temp = bmp280.temperature
		press = bmp280.pressure
		alt = bmp280.altitude
		# a Python object (dict):
		bmp280Json = {
		  "Temp":temp,
		  "Pressure":press,
		  "Alt":alt
		}

		return json.dumps(bmp280Json)

	@cherrypy.expose
	def bmp280Temp(self):
		bmp280 = bmp280Sensor()
		temp = bmp280.temperature
		tempJson = {'Temp': temp}

		return json.dumps(tempJson)

if __name__ == '__main__':
    cherrypy.config.update({'server.socket_host': '0.0.0.0'})
    cherrypy.quickstart(SensorData())
