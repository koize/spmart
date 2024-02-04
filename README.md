![image](https://github.com/koize/spmart/assets/122030611/c1d12849-100c-4ca8-83e6-b743f87bf237)# Supermarket Self-Checkout System

An IOT Self-Checkout System to reduce the time required for customers at a supermarket to pay for their purchases, as well as integrate an Online Store for customers to purchase and self-collect or deliver to their home.

# Features

## Online Purchases

* Online Website for customers to purchase and checkout online
* Option to pick up items from the supermarket themselves or deliver directly to their homes with a delivery fee of $4.00
* Online customers who opt to collect their items from the supermarket will receive a QR code after online payment that they will need to show to the supermarket staff to collect their items
* Live server link: http://koize.southeastasia.cloudapp.azure.com/index.php

## In-store Purchases

* Self-checkout system where customers scan their products themselves using a camera, and the system will sum up the total and process payment
* Two payment choices: ATM via PIN Code, **OR** Contactless "PayWave" Credit Card

## Non-functional features

* Idle Mode
* Used to keep the system in low power mode when no one is using or interacting with the system

# Components used and their purpose

| Component         | Input/Output | Purpose                                                                                           | Customer’s requirements                                           |
|-------------------|--------------|---------------------------------------------------------------------------------------------------|-------------------------------------------------------------------|
| Ultrasonic Sensor | Input        | To detect customer presence                                                                       | -                                                                 |
| Camera            | Input        | To scan products to fetch product attributes                                                      | Read product barcode to fetch product prices and other attributes |
| RFID Reader       | Input        | To read customer’s credit card                                                                    | Read customer’s credit card for “PayWave” support                 |
| Keypad            | Input        | To allow customers to interact with the system (i.e confirm total price, payment choice, ATM PIN) | Allow customer to enter ATM PIN code for payment                  |
| LED               | Output       | To show system state                                                                              | -                                                                 |
| Buzzer            | Output       | To provide information/alerts to customer                                                         | -                                                                 |
| LCD               | Output       | To provide information to customer                                                                | Display product name, price, cumulative total                     |

# Software used

* Python
* Visual Studio Code
