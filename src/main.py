# Local imports
from threading import Thread
from hal import hal_led as led
from hal import hal_lcd as LCD
from hal import hal_keypad as keypad
from hal import hal_buzzer as buzzer
from hal import hal_rfid_reader as rfid_reader
import queue
import cam
import time

shared_keypad_queue = queue.Queue()


#Call back function invoked when any key on keypad is pressed
def key_pressed(key):
    shared_keypad_queue.put(key)


def delete_key_pressed():
    shared_keypad_queue.empty()

def home_screen():
    lcd = LCD.lcd()
    while True:
        key = shared_keypad_queue.get()
        #key = keypad.get_key()
        if key in [1, 2]:
            menu_selection(key)
            break  # Exit the loop if a valid key is pressed
        else:
            lcd.lcd_display_string("Invalid number")
            time.sleep(2)
            display_main_menu()


def display_main_menu():
    # Instantiate and initialize the LCD driver
    lcd = LCD.lcd()
    # Clear LCD and display main menu
    lcd.lcd_clear()
    lcd.lcd_display_string("1. Start self-checkout", 1)  # write on line 1
    lcd.lcd_display_string("2. Enter Idle Mode", 2)  # write on line 2

def menu_selection(option):
    lcd = LCD.lcd()

    if option == 1:
        # Display "Start self-checkout" message
        lcd.lcd_clear()
        lcd.lcd_display_string("Hold your items", 1)
        lcd.lcd_display_string("at reader one by one", 2)
        camera_scanning()

    elif option == 2:
        # Display "Entering Idle Mode" message
        lcd.lcd_clear()
        lcd.lcd_display_string("Entering Idle Mode", 1)
        lcd.lcd_display_string("", 2)  # Blank line 2

        # Wait for 2 seconds 
        time.sleep(2)

        # Turn off LCD and backlight
        lcd.lcd_clear()
        while True:
            key = shared_keypad_queue.get()
            #key = keypad.get_key()
            if key != None:
                home_screen()
                break


def camera_scanning():
    # data = cam.scan_qr()
    display_payment_screen(10)
    

def buzzer_scanning():
    buzzer.beep(0.1, 0, 1)

#after scanning 
def display_payment_screen(total_price):
    lcd = LCD.lcd()

    # Display total price on line 1
    lcd.lcd_display_string("Total Price: $" + str(total_price), 1)

    while True:
        # Display initial message on line 2
        lcd.lcd_display_string("Press 1 to pay", 2)

        # Wait for 3 seconds before changing the message
        time.sleep(3)

        # Clear line 2 and display the second message
        lcd.lcd_display_string("Press 2 to add more", 2)

        key = shared_keypad_queue.get()
        if key == 1:
            display_payment_method_menu()
            break
        elif key == 2:
            # Process to camera scanning
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
        pay_with_atm()
    elif key == 2:
        pay_with_paywave()
    else:
        lcd.lcd_display_string("Invalid number", 2)
        time.sleep(2)
        display_payment_method_menu()

    time.sleep(2)
    lcd.lcd_clear()
    lcd.lcd_display_string("Thank you", 1)
    lcd.lcd_display_string("Come again!", 2)
    time.sleep(2)
    display_main_menu()
    menu_selection(2)



def pay_with_atm():
    lcd = LCD.lcd()
    lcd.lcd_clear()
    lcd.lcd_display_string("Enter your PIN", 1)
    lcd.lcd_display_string("Press # to confirm", 2)
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


def verify_pin(pin):
    lcd = LCD.lcd()
    print(pin)
    lcd.lcd_clear()
    lcd.lcd_display_string("Verifying", 1)
    time.sleep(2)
    if pin == "1234":
        lcd.lcd_display_string("PIN verified", 1)
    elif pin != "1234":
        lcd.lcd_display_string("Invalid PIN", 1)
        time.sleep(2)
        pay_with_atm()


def pay_with_paywave():
    reader = rfid_reader.init()
    lcd = LCD.lcd()
    lcd.lcd_clear()
    lcd.lcd_display_string("Tap your card", 1)
    while True:
        id = reader.read_id_no_block()
        id = str(id)
        if id != "None":
            buzzer.beep(1, 0, 1)
            print("RFID card ID = " + id)
            # Display RFID card ID on LCD line 2
            lcd.lcd_display_string(id, 2) 
            time.sleep(1) 
            lcd.lcd_clear()
            lcd.lcd_display_string("Approved", 1)
            time.sleep(2) 
            break  



def main():
    #Initiallize LED driver
    led.init()
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