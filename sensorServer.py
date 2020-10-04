
import board
import digitalio
import busio
import time
import adafruit_bmp280
import adafruit_dht

# For DS18B20
import os
import re
from glob import glob

# General use
import random
import string
import json

from gpiozero import CPUTemperature

import cherrypy

# Initial the dht device, with data pin connected to:
dhtDevice = adafruit_dht.DHT11(board.D4)

# Create library object using our Bus I2C port
i2c = busio.I2C(board.SCL, board.SDA)

# Folder with 1-Wire devices
w1DeviceFolder = '/sys/bus/w1/devices'

# Sensor
def bmp280Sensor():
	return adafruit_bmp280.Adafruit_BMP280_I2C(i2c)

def cpuTemp():
	return CPUTemperature()

def dht11Data():
	try:
		temperature_c = dhtDevice.temperature
		humidity = dhtDevice.humidity

		# a Python object (dict):
		dht11Json = {
		  "Temp":temperature_c,
		  "Humidity":humidity,
		}
		
	except RuntimeError as error:
		return 'Errors happen :('
	return dht11Json

### DS18B20 ###
# Function that returns array with IDs of all found thermometers
def find_thermometers():
    # Get all devices
    w1Devices = glob(w1DeviceFolder + '/*/')
    # Create regular expression to filter only those starting with '28', which is thermometer
    w1ThermometerCode = re.compile(r'28-\d+')
    # Initialize the array
    thermometers = []
    # Go through all devices
    for device in w1Devices:
        # Read the device code
        deviceCode = device[len(w1DeviceFolder)+1:-1]
        # If the code matches thermometer code add it to the array
        if w1ThermometerCode.match(deviceCode):
            thermometers.append(deviceCode)
    # Return the array
    return thermometers

# Function that reads and returns the raw content of 'w1_slave' file
def read_temp_raw(deviceCode):
    f = open(w1DeviceFolder + '/' + deviceCode + '/w1_slave' , 'r')
    lines = f.readlines()
    f.close()
    return lines

# Function that reads the temperature from raw file content
def read_temp(deviceCode):
    # Read the raw temperature data
    lines = read_temp_raw(deviceCode)
    # Wait until the data is valid - end of the first line reads 'YES'
    while lines[0].strip()[-3:] != 'YES':
        time.sleep(0.2)
        lines = read_temp_raw(deviceCode)
    # Read the temperature, that is on the second line
    equals_pos = lines[1].find('t=')
    if equals_pos != -1:
        temp_string = lines[1][equals_pos+2:]
        # Convert the temperature number to Celsius
        temp_c = float(temp_string) / 1000.0
        # Convert the temperature to Fahrenheit
        temp_f = temp_c * 9.0 / 5.0 + 32.0
        # Return formatted sensor data
        return temp_c

### DS18B20 END ###

class SensorData(object):

	@cherrypy.expose
	def index(self):
		return "Hello world!"

	@cherrypy.expose
	def allData(self):

		return "All data goes here!"

	@cherrypy.expose
	def bmp280(self):
		bmp280 = bmp280Sensor()

		# change this to match the location's pressure (hPa) at sea level
		bmp280.seaLevelhPa = 1014
		temp = bmp280.temperature
		press = bmp280.pressure
		alt = bmp280.altitude
		# a Python object (dict):
		bmp280Json = {
		  "Id":1,
		  "Temp":temp,
		  "Pressure":press,
		  "Alt":alt
		}

		return json.dumps(bmp280Json)

	@cherrypy.expose
	def dht11(self):
		dht11_data = dht11Data()

		return json.dumps(dht11_data)

	@cherrypy.expose
	def ds18b20(self):
		ds18b20_data = {}
		# Find all connected thermometers
		thermometers = find_thermometers()
		i = 0

		# Go through all connected thermometers
		for thermometer in thermometers:
			# Pretty print sensor data
		    # ds18b20_data[thermometer] = read_temp(thermometer)
		    ds18b20_data[i] = {
		    	"Id":thermometer,
		    	"Temp":read_temp(thermometer)
		    }
		    i = i+1

		return json.dumps(ds18b20_data)

if __name__ == '__main__':
    cherrypy.config.update({'server.socket_host': '0.0.0.0'})
    cherrypy.quickstart(SensorData())
