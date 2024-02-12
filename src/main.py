# Local imports
from threading import Thread
from hal import hal_led as LED
from hal import hal_lcd as LCD
from hal import hal_keypad as keypad
from hal import hal_buzzer as buzzer
from hal import hal_rfid_reader as rfid_reader
import queue
import cam
import time
import database as db
from pyzbar.pyzbar import decode


shared_keypad_queue = queue.Queue()
total = 0
#Call back function invoked when any key on keypad is pressed
def key_pressed(key):
    shared_keypad_queue.put(key)


def delete_key_pressed():
    shared_keypad_queue.empty()

def home_screen():
    lcd = LCD.lcd()
    display_main_menu()
    while True:
        key = shared_keypad_queue.get()
        buzzer.beep(0.1, 0, 1)
        menu_selection()
        #key = keypad.get_key()


def display_main_menu():
    # Instantiate and initialize the LCD driver
    lcd = LCD.lcd()
    # Clear LCD and display main menu
    lcd.lcd_clear()
    lcd.lcd_display_string("SPmart Menu", 1)  # write on line 1
    lcd.lcd_display_string("1.Self-checkout", 2)  # write on line 2

def menu_selection():
    lcd = LCD.lcd()
    buzzer.beep(0.1, 0, 1)
    lcd.lcd_clear()
    lcd.lcd_display_string("Scan item", 1)
    lcd.lcd_display_string("at camera", 2)
    time.sleep(2)
    camera_scanning()
    return 1


def camera_scanning():
    LED.init()
    global total 
    lcd = LCD.lcd()
    lcd.lcd_clear()  
    lcd.lcd_display_string("Press 1 to add", 1)    
    lcd.lcd_display_string("Total $" + str(total), 2)    
    while True:
        LED.set_output(1, 1)
        data = cam.scan_barcode()
        buzzer.beep(0.1, 0, 1)
        data.decode('utf-8')
        #data = "1000000001" # Hardcoded for testing
        product_name = db.fetch_product_name(data)
        product_price = db.fetch_product_price(data)
        total += product_price
        lcd.lcd_clear()
        lcd.lcd_display_string(product_name, 1)
        lcd.lcd_display_string("$" + str(product_price) + ", Total $" + str(total), 2)
        key = shared_keypad_queue.get()
        #key = keypad.get_key()
        if key == 1:
            buzzer.beep(0.1, 0, 1)
            LED.set_output(1, 0)
            continue
        elif key !=1:
            buzzer.beep(0.1, 0, 1)
            LED.set_output(1, 0)
            display_payment_screen(total)
            break

    

#after scanning 
def display_payment_screen(total_price):
    lcd = LCD.lcd()

    # Display total price on line 1
    lcd.lcd_display_string("Total: $" + str(total_price), 1)

    while True:
        # Display initial message on line 2
        lcd.lcd_display_string("1.Pay 2. Add", 2)

        key = shared_keypad_queue.get()
        if key == 1:
            buzzer.beep(0.1, 0, 1)
            display_payment_method_menu()
            break
        elif key == 2:
            buzzer.beep(0.1, 0, 1)
            camera_scanning()
            break
        

def display_payment_method_menu():
    lcd = LCD.lcd()
    
    # Clear the LCD
    lcd.lcd_clear()

    # Display the payment method menu
    lcd.lcd_display_string("Payment Method?", 1)
    lcd.lcd_display_string("1.ATM,2.PayWave", 2)
    key = shared_keypad_queue.get()
    if key == 1:
        buzzer.beep(0.1, 0, 1)
        pay_with_atm()
    elif key == 2:
        buzzer.beep(0.1, 0, 1)
        pay_with_paywave()
    else:
        lcd.lcd_display_string("Invalid number", 2)
        time.sleep(2)
        display_payment_method_menu()

    time.sleep(2)
    lcd.lcd_clear()
    lcd.lcd_display_string("Thank you", 1)
    lcd.lcd_display_string("Come again!", 2)
    global total
    total = 0
    time.sleep(2)
    display_main_menu()
    menu_selection(2)



def pay_with_atm():
    lcd = LCD.lcd()
    lcd.lcd_clear()
    lcd.lcd_display_string("Enter your PIN", 1)
    lcd.lcd_display_string("# to confirm", 2)
    delete_key_pressed()
    sekrit = ""
    pin = ""
    while True:
        key = shared_keypad_queue.get()
        if key in [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]:
            buzzer.beep(0.1, 0, 1)
            sekrit += "*" 
            lcd.lcd_clear()
            lcd.lcd_display_string(sekrit, 2)
            pin += str(key)
            print(key)
        elif key == "#":
            buzzer.beep(0.1, 0, 1)
            verify_pin(pin)
            break
    return 1


def verify_pin(pin):
    LED.init()
    lcd = LCD.lcd()
    print(pin)
    lcd.lcd_clear()
    lcd.lcd_display_string("Verifying", 1)
    time.sleep(2)
    if pin == "1234":
        lcd.lcd_display_string("PIN verified", 1)
        LED.set_output(1, 1)
        buzzer.beep(0.1, 0, 1)
        buzzer.beep(0.1, 0, 1)
        LED.set_output(1, 0)
        return 1
    elif pin != "1234":
        lcd.lcd_display_string("Invalid PIN", 1)
        LED.set_output(1, 1)
        buzzer.beep(0.1, 0, 1)
        buzzer.beep(0.1, 0, 1)
        buzzer.beep(0.1, 0, 1)
        time.sleep(2)
        LED.set_output(1, 0)
        return 0
        pay_with_atm()


def pay_with_paywave():
    LED.init()
    buzzer.init()
    reader = rfid_reader.init()
    lcd = LCD.lcd()
    lcd.lcd_clear()
    lcd.lcd_display_string("Tap your card", 1)
    while True:
        id = reader.read_id_no_block()
        id = str(id)
        if id != "None":
            buzzer.beep(1, 0, 1)
            lcd.lcd_display_string("Authorising...")
            print("RFID card ID = " + id)
            # Display RFID card ID on LCD line 2
            lcd.lcd_display_string(id, 2) 
            time.sleep(1) 
            lcd.lcd_clear()
            LED.set_output(1, 1)
            lcd.lcd_display_string("Approved", 1)
            buzzer.beep(0.1, 0, 1)
            buzzer.beep(0.1, 0, 1)
            time.sleep(2) 
            LED.set_output(1, 0)
            break  



def main():
    #Initiallize LED driver
    keypad.init(key_pressed)
    buzzer.init()
    keypad_thread = Thread(target=keypad.get_key)
    keypad_thread.start()
    

    #Initiallize Keypad driver

    # Instantiate and initialize the LCD driver
    lcd = LCD.lcd()
    home_screen()

# Main entry point
if __name__ == "__main__":
    main()