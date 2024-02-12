import pytest
from unittest.mock import patch, MagicMock
from hal import hal_led, hal_lcd, hal_keypad, hal_buzzer, hal_rfid_reader
import queue
import time
import database as db
import main
from main import key_pressed, delete_key_pressed, display_main_menu

@pytest.fixture
def shared_keypad_queue():
    return queue.Queue()

@pytest.fixture
def lcd():
    return hal_lcd.lcd()

@pytest.fixture
def keypad_thread():
    return MagicMock()

@pytest.fixture
def keypad():
    return hal_keypad

@pytest.fixture
def buzzer():
    return hal_buzzer

@pytest.fixture
def rfid_reader():
    reader = hal_rfid_reader.init()
    return reader

@pytest.fixture
def cam():
    return MagicMock()

@pytest.fixture
def db():
    return MagicMock()

@pytest.fixture
def LED():
    return hal_led

def test_key_pressed(shared_keypad_queue):
    key_pressed(1)
    assert shared_keypad_queue.get() == 1

def test_delete_key_pressed(shared_keypad_queue):
    shared_keypad_queue.put(1)
    delete_key_pressed()
    assert shared_keypad_queue.empty()

def test_display_main_menu(lcd):
    display_main_menu()
    assert lcd.lcd_display_string.call_args_list == [
        (("SPmart Menu", 1),),
        (("1.Self-checkout", 2),)
    ]

def test_menu_selection(lcd, buzzer, shared_keypad_queue):
    shared_keypad_queue.put(1)
    main.menu_selection(1)
    assert lcd.lcd_clear.call_count == 1
    assert lcd.lcd_display_string.call_args_list == [
        (("Scan item", 1),),
        (("at camera", 2),)
    ]
    assert buzzer.beep.call_args_list == [((0.1, 0, 1),)]

def test_camera_scanning(LED, lcd, cam, db, buzzer, shared_keypad_queue):
    cam.scan_barcode.return_value = "1234567890"
    db.fetch_product_name.return_value = "Product 1"
    db.fetch_product_price.return_value = 10.0
    shared_keypad_queue.put(1)
    main.camera_scanning()
    assert LED.init.call_count == 1
    assert lcd.lcd_clear.call_count == 1
    assert lcd.lcd_display_string.call_args_list == [
        (("Press 1 to add", 1),),
        (("Total $0", 2),)
    ]
    assert cam.scan_barcode.call_count == 1
    assert LED.set_output.call_args_list == [((1, 1),), ((1, 0),)]
    assert buzzer.beep.call_args_list == [((0.1, 0, 1),)] * 4
    assert lcd.lcd_display_string.call_args_list == [
        (("Product 1", 1),),
        (("$10.0, Total $10.0", 2),)
    ]

def test_display_payment_screen(lcd, shared_keypad_queue):
    shared_keypad_queue.put(1)
    main.display_payment_screen(10.0)
    assert lcd.lcd_display_string.call_args_list == [(("Total: $10.0", 1),)]
    assert lcd.lcd_display_string.call_args_list == [(("1.Pay 2. Add", 2),)]

def test_display_payment_method_menu(lcd, buzzer, shared_keypad_queue):
    shared_keypad_queue.put(1)
    main.display_payment_method_menu()
    assert lcd.lcd_clear.call_count == 1
    assert lcd.lcd_display_string.call_args_list == [
        (("Payment Method?", 1),),
        (("1.ATM,2.PayWave", 2),)
    ]
    assert buzzer.beep.call_args_list == [((0.1, 0, 1),)]

def test_pay_with_atm(lcd, buzzer, shared_keypad_queue):
    shared_keypad_queue.put(1)
    main.pay_with_atm()
    assert lcd.lcd_clear.call_count == 1
    assert lcd.lcd_display_string.call_args_list == [(("Enter your PIN", 1),), (("# to confirm", 2),)]
    assert buzzer.beep.call_args_list == [((0.1, 0, 1),)]

def test_verify_pin():
    hal_led.init()
    hal_buzzer.init()
    assert main.verify_pin("1234") == 1

def test_pay_with_paywave(rfid_reader):
    main.pay_with_paywave()
    assert str(rfid_reader.read_id_no_block) != "None"




