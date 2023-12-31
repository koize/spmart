# Supermarket Self-Checkout System

An IOT Self-Checkout System to reduce the time required for customers at a supermarket to pay for their purchases, as well as integrate an Online Store for customers to purchase and self-collect or deliver to their home.

# Features

## Online Purchases

* Online Website for customers to purchase and checkout online
* Option to pick up items from the supermarket themselves or deliver directly to their homes with a delivery fee of $4.00
* Online customers that opt to collect their items from the supermarket will receive a QR code after online payment that they will need to show to the supermarket staff to collect their items

## In-store Purchases

* Self-checkout system where customers scan their products themselves, and the system will sum up the total and process payment
* Two payment choices: ATM via PIN Code, **OR** Contactless "PayWave" Credit Card

# Components used and their purpose

| Component         | Input/Output | Purpose                                                                                           | Customer’s requirements                                                                                             |
|-------------------|--------------|---------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------|
| Ultrasonic Sensor | Input        | To detect customer presence                                                                       | -                                                                                                                   |
| RFID Reader       | Input        | To read products and customer’s credit card                                                       | Read product barcode to fetch product prices and other attributes Read customer’s credit card for “PayWave” support |
| Keypad            | Input        | To allow customers to interact with the system (i.e confirm total price, payment choice, ATM PIN) | Allow customer to enter ATM PIN code for payment                                                                    |
| LED               | Output       | To show system state                                                                              | -                                                                                                                   |
| Buzzer            | Output       | To provide information/alerts to customer                                                         | -                                                                                                                   |
| LCD               | Output       | To provide information to customer                                                                | Display product name, price, cumulative total                                                                       |

# Software used

* Python
* Visual Studio Code
