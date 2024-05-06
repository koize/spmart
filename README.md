# Supermarket Self-Checkout System

An IOT Self-Checkout System based on Raspberry Pi to reduce the time required for customers at a supermarket to pay for their purchases, as well as integrate an Online Store for customers to purchase and self-collect or deliver to their home.

# Features

## Online Purchases

* Online Website for customers to purchase and checkout online
* Option to pick up items from the supermarket themselves or deliver directly to their homes with a delivery fee of $4.00
* Online customers who opt to collect their items from the supermarket will receive a QR code after online payment that they will need to show to the supermarket staff to collect their items

## In-store Purchases

* Self-checkout system where customers scan their products themselves using a camera, and the system will sum up the total and process payment
* Two payment choices: ATM via PIN Code, **OR** Contactless "PayWave" Credit Card


# Components used and their purpose

| Component         | Input/Output | Purpose                                                                                           | Customer’s requirements                                           |
|-------------------|--------------|---------------------------------------------------------------------------------------------------|-------------------------------------------------------------------|
| Camera            | Input        | To scan products to fetch product attributes                                                      | Read product barcode to fetch product prices and other attributes |
| RFID Reader       | Input        | To read customer’s credit card                                                                    | Read customer’s credit card for “PayWave” support                 |
| Keypad            | Input        | To allow customers to interact with the system (i.e confirm total price, payment choice, ATM PIN) | Allow customer to enter ATM PIN code for payment                  |
| LED               | Output       | To show system state                                                                              | -                                                                 |
| Buzzer            | Output       | To provide information/alerts to customer                                                         | -                                                                 |
| LCD               | Output       | To provide information to customer                                                                | Display product name, price, cumulative total                     |

SRS Document Link: https://docs.google.com/document/d/1KI1t0F_MUq326-t64G1bKelGiXduWvid/edit?usp=sharing&ouid=114512483305245631570&rtpof=true&sd=true

Video Demo: https://youtu.be/86UFBxuNeWI

Azure Deployment (store only): http://koize.southeastasia.cloudapp.azure.com/

# Software used

* Python
* PHP
* MySQL
* Docker Compose
* Visual Studio Code
* OpenCV

# Hardware used
* Raspberry Pi
* DevOps Development Board
* PiCamera2

# How to use
Git clone on a **Raspberry Pi** with `https://github.com/ET0735-DevOps-AIoT-AY2320/DCPE_2A_22_Group2.git` 

Ensure Docker Compose is installed

Navigate to root of project: `cd spmart/`

Run Container with `docker compose up -d`

