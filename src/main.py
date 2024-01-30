# Local imports
from hal import hal_led as led
from hal import hal_lcd as LCD
from hal import hal_keypad as keypad
from hal import hal_buzzer as buzzer
import time

def display_main_menu():
    # Instantiate and initialize the LCD driver
    lcd = LCD.lcd()

    # Clear LCD and display main menu
    lcd.lcd_clear()
    lcd.lcd_display_string("1. Start self-checkout", 1)  # write on line 1
    lcd.lcd_display_string("2. Enter Idle Mode", 2)  # write on line 2

def menu_selection(option):
    lcd = LCD.lcd()

    if option == "1":
        # Display "Start self-checkout" message
        lcd.lcd_clear()
        lcd.lcd_display_string("Hold your items", 1)
        lcd.lcd_display_string("at reader one by one", 2)

        camara_scanning()

    elif option == "2":
        # Display "Entering Idle Mode" message
        lcd.lcd_clear()
        lcd.lcd_display_string("Entering Idle Mode", 1)
        lcd.lcd_display_string("", 2)  # Blank line 2

        # Wait for 2 seconds 
        time.sleep(2)

        # Turn off LCD and backlight
        lcd.lcd_clear()
        lcd.lcd_backlight(0)

def camera_scanning():
    #code for camera
    

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
        lcd.lcd_clear_line(2)
        lcd.lcd_display_string("Press 2 to add more", 2)

        key = keypad.get_key()
        if key == "1":
            # Process to payment
            break
        elif key == "2":
            # Process to camera scanning
            break
        
def display_payment_method_menu():
    lcd = LCD.lcd()

    # Clear the LCD
    lcd.lcd_clear()

    # Display the payment method menu
    lcd.lcd_display_string("Payment Method?", 1)
    lcd.lcd_display_string("1. ATM, 2. PayWave", 2)
        

def main():
    #Initiallize LED driver
    led.init()

    #Initiallize Keypad driver
    keypad.init()

    # Instantiate and initialize the LCD driver
    lcd = LCD.lcd()

    display_main_menu()

    while True:
        display_main_menu()

        key = keypad.get_key()
        if key in ["1", "2"]:
            menu_selection(key)
            break  # Exit the loop if a valid key is pressed
        else:
            lcd.lcd_display_string("Invalid number")

# Main entry point
if __name__ == "__main__":
    main()