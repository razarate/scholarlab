import board
import digitalio
import busio
import time
import adafruit_bme280
# import adafruit_bmp280
# import adafruit_dht
from gpiozero import Button, LED
from signal import pause
import sys

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

# Shutdown button
offGPIO = int(sys.argv[1]) if len(sys.argv) >= 2 else 19
holdTime = int(sys.argv[2]) if len(sys.argv) >= 3 else 6
ledGPIO = int(sys.argv[3]) if len(sys.argv) >= 4 else 13

# Initial the dht device, with data pin connected to:
#dhtDevice = adafruit_dht.DHT11(board.D4)

# Create library object using our Bus I2C port
i2c = busio.I2C(board.SCL, board.SDA)

# Folder with 1-Wire devices
w1DeviceFolder = '/sys/bus/w1/devices'

# Sensor
def bmp280Sensor():
	return adafruit_bmp280.Adafruit_BMP280_I2C(i2c)

def bme280Sensor():
	return adafruit_bme280.Adafruit_BME280_I2C(i2c, 0x76)

def bme280_data_array():
	bme280 = bme280Sensor()
	bme280_data = {}

	# change this to match the location's pressure (hPa) at sea level
	bme280.seaLevelhPa = 1014
	temp = bme280.temperature
	humidity = bme280.humidity
	press = bme280.pressure
	alt = bme280.altitude
	address = '0x76'
	
	# a Python object (dict):
	bme280_data[address] = {
	  "Id":1,
	  "Temp":temp,
	  "Humidity":humidity,
	  "Pressure":press,
	  "Alt":alt
	}
	return bme280_data

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

def ds18b20_data_array():
	ds18b20_data = {}
	# Find all connected thermometers
	thermometers = find_thermometers()
	i = 0

	# Go through all connected thermometers
	for thermometer in thermometers:
		# Pretty print sensor data
	    # ds18b20_data[thermometer] = read_temp(thermometer)
	    ds18b20_data[thermometer] = {
	    	"Id":thermometer,
	    	"Temp":read_temp(thermometer)
	    }
	    i = i+1

	return ds18b20_data

### DS18B20 END ###

### Shutdown button Start ###
def when_pressed():
    # start blinking with 1/2 second rate
    led.blink(on_time=0.5, off_time=0.5)

def when_released():
    # be sure to turn the LEDs off if we release early
    led.off()

def shutdown():
    os.system("sudo poweroff")

led = LED(ledGPIO)
btn = Button(offGPIO, hold_time=holdTime)
btn.when_held = shutdown
btn.when_pressed = when_pressed
btn.when_released = when_released

### Shutdown button Start ###

class SensorData(object):

	@cherrypy.expose
	def index(self):
		return "Hello world!"

	@cherrypy.expose
	def allData(self):
		# a Python object (dict):
		allData = [bme280_data_array(), ds18b20_data_array()]

		return json.dumps(allData)

	@cherrypy.expose
	def bme280(self):

		return json.dumps(bme280_data_array())

	@cherrypy.expose
	def bmp280(self):
		bmp280 = bmp280Sensor()

		# change this to match the location's pressure (hPa) at sea level
		bmp280.seaLevelhPa = 1014
		temp = bmp280.temperature
		press = bmp280.pressure
		alt = bmp280.altitude
		# a Python object (dict):
		bmp280_data = {
		  "Id":1,
		  "Temp":temp,
		  "Pressure":press,
		  "Alt":alt
		}

		return json.dumps(bmp280_data)

	@cherrypy.expose
	def dht11(self):
		dht11_data = dht11Data()

		return json.dumps(dht11_data)

	@cherrypy.expose
	def ds18b20(self):

		return json.dumps(ds18b20_data_array())

if __name__ == '__main__':
    cherrypy.config.update({'server.socket_host': '0.0.0.0'})
    cherrypy.quickstart(SensorData())
